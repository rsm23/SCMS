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
@stop