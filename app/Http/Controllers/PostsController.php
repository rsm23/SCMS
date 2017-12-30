<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::latest()->get();

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

        $image = url($request->file('featured_image')->store('uploads/posts/featured',
            'public'));

        Post::create([
            'user_id'        => auth()->id(),
            'title'          => $request->title,
            'category_id'    => $request->category_id,
            'featured_image' => $image,
            'body'           => $request->body
        ]);

        return redirect('/blog/');
    }

    public function addReply()
    {

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

        ($request->file('featured_image')) ? $image = url($request->file('featured_image')->store('uploads/posts/featured',
            'public')) : $image = $post->featured_image;

        $post->slug = null;

        $post->update([
            'user_id'        => auth()->id(),
            'title'          => $request->title,
            'featured_image' => $image,
            'category_id'    => $request->category_id,
            'body'           => $request->body
        ]);

        return redirect($post->path());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post $post
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Exception
     */
    public function destroy(Post $post)
    {
        $this->authorize('update', $post);

        $post->delete();
        if (request()->wantsJson()) {
            return response([], 204);
        }

        return redirect('/blog');
    }
}
