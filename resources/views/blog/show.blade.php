@extends('layouts.app')

@section('content')
    <figure class="hero d-flex align-items-center justify-content-center"
            style="background: url('{{ $post->featured_image }}') no-repeat center center fixed;background-size: cover;">
        <h1 class="text-center">{{ $post->title }}</h1>
    </figure>
    <div class="container">
        <div class="row">
            <article class="card blog-body">
                <div class="card-body">
                    <h5 class="card-title"><a href="#">{{ $post->owner->name }}</a></h5>
                    <h6 class="card-subtitle mb-2 text-muted">{{ $post->created_at->diffForHumans() }}</h6>
                    @markdown($post->body)
                </div>
            </article>
        </div>

        <div class="row mt-5">
            @foreach($post->replies as $reply)
                @include('blog._reply')
            @endforeach
        </div>
    </div>

    <div id="addReply" class="d-flex align-content-center mt-5 p-2">
        <div class="container">
            @if (auth()->check())
                <div class="row mt-5">
                    <form action="{{ route('blogAddReply', [$post->category, $post->slug]) }}" method="POST" style="width: 100%">
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