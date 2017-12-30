<?php

namespace App\Http\Controllers;

use App\Post;
use App\Reply;
use Illuminate\Http\Request;

class RepliesController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param           $channelId
     * @param \App\Post $post
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store($channelId, Post $post)
    {
        $post->addReply([
            'body' => request('body'),
            'user_id' => auth()->id()
        ]);

        return back();
    }
}
