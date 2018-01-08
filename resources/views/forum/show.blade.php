@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <article class="card blog-body">
                <div class="card-body">
                    <h5 class="card-title"><a href="#">{{ $thread->owner->name }}</a></h5>
                    <h6 class="card-subtitle mb-2 text-muted">{{ $thread->created_at->diffForHumans() }}{!!  ($edited) ? '<span class="text-success float-right"> Edited by : '.$edited->name.'</span>' : ''  !!}</h6>
                    @markdown($thread->body)
                </div>
            </article>
        </div>

        <div class="row mt-5">
            @foreach($thread->replies as $reply)
                @include('partials._reply')
            @endforeach
        </div>
    </div>

    <div id="addReply" class="d-flex align-content-center mt-5 p-2">
        <div class="container">
            @if (auth()->check())
                <div class="row mt-5">
                    <form action="{{ route('forumAddReply', [$thread->category, $thread->slug]) }}" method="POST"
                          style="width: 100%">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <textarea name="body" id="reply" class="form-control"
                                      placeholder="Have something to say?"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary float-right">Post reply</button>
                    </form>
                </div>
            @else
                <p class="text-center" style="margin-bottom: 0">Please <a href="{{ route('login') }}">Sign in</a> or <a
                            href="{{ route('register') }}">Register</a> to participate</p>
            @endif
        </div>
    </div>
@stop