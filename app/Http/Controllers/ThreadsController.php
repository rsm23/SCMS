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
        return view('forum.show', compact('thread'));
    }
}
