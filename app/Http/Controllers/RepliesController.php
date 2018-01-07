<?php

namespace App\Http\Controllers;

use App\Post;
use App\Reply;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class RepliesController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param                                     $categoryId
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store($categoryId, Model $model)
    {
        $model->reply([
            'user_id' => auth()->id(),
            'body' => request('body')
        ]);

        return back();
    }
}
