<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use App\User;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \App\Category $category
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Category $category)
    {
        if ($category->exists) {
            $posts = $category->posts()->latest();
        } else {
            $posts = Post::latest();
        }

        if ($name = request('by')) {
            $user = User::where('name', $name)->firstOrFail();
            $posts->where('user_id', $user->id);
        }

        $posts = $posts->get();

        return view('blog.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        auth()->user()->authorizeRoles(['editor', 'admin']);
        $categories = Category::all();

        return view('blog.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->user()->authorizeRoles(['editor', 'admin']);

        $request->validate([
            'title'          => 'required|max:255|min:4',
            'category_id'    => 'required|exists:categories,id',
            'featured_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'body'           => 'required',
        ]);

        if ($image = $request->file('featured_image')) {
            url($image->store('uploads/posts/featured',
                'public'));
        }
        $request->request->add(['user_id' => auth()->id()]);

        Post::create($request->all());

        return redirect('/blog/');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Category $category
     * @param  \App\Post    $post
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category, Post $post)
    {
        return view('blog.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Category $category
     * @param  \App\Post    $post
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category, Post $post)
    {
        $categories = $category->all();
        if (auth()->user()->can('update', $post)) {
            return view('blog.edit', compact(['post' => 'post', 'categories' => 'categories']));
        } else {
            return redirect($post->path());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param \App\Category             $category
     * @param  \App\Post                $post
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, Category $category, Post $post)
    {
        $this->authorize('update', $post);

        $request->validate([
            'title'          => 'required|max:255|min:4',
            'category_id'    => 'required|exists:categories,id',
            'featured_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'body'           => 'required',
        ]);

        if ($image = $request->file('featured_image')){
            url($image->store('uploads/posts/featured',
                'public'));
        }

        $post->slug = null;
        $request->request->add(['user_id' => auth()->id()]);
        $post->update($request->all());

        return redirect($post->path());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Category $category
     * @param  \App\Post    $post
     *
     * @return \Illuminate\Http\Response
     * @throws \Exception
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Category $category, Post $post)
    {
        $this->authorize('update', $post);

        $post->delete();
        if (request()->wantsJson()) {
            return response([], 204);
        }

        return redirect('/blog');
    }
}
