<?php

namespace App\Http\Controllers;

use App\Category;
use App\Thread;
use App\User;
use Illuminate\Http\Request;

class ThreadsController extends Controller
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
            $threads = $category->threads()->latest();
        } else {
            $threads = Thread::latest();
        }

        if ($name = request('by')) {
            $user = User::where('name', $name)->firstOrFail();
            $threads->where('user_id', $user->id);
        }

        $threads = $threads->get();

        return view('forum.index', compact('threads'));
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Category $category
     * @param \App\Thread   $thread
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category, Thread $thread)
    {
        $edited = false;

        if($id = $thread->edited_by){
            $edited = User::findOrFail($id);
        }
        return view('forum.show', compact(['thread' => 'thread', 'edited' => 'edited']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Category $category
     * @param \App\Thread   $thread
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category, Thread $thread)
    {
        if (auth()->user()->can('update', $thread)) {
            return view('forum.edit', compact('thread'));
        } else {
            return redirect($thread->path());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param \App\Category             $category
     * @param \App\Thread               $thread
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, Category $category, Thread $thread)
    {
        $this->authorize('update', $thread);

        $request->validate([
            'title'          => 'required|max:255|min:4',
            'category_id'    => 'required|exists:categories,id',
            'body'           => 'required',
        ]);

        $thread->slug = null;
        $request->request->add(['edited_by' => auth()->id()]);
        $thread->update($request->all());

        return redirect($thread->path());
    }
}
