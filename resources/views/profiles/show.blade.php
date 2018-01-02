@extends('layouts.app')

@section('content')
    <section class="jumbotron text-center">
        <div class="container">
            <h1 class="jumbotron-heading">{{ $user->name }}</h1>
            <p class="lead text-muted"><i class="fa fa-bar-chart btn btn-success" title="stats"></i> : <a
                        href="/blog?by={{ $user->name }}" class="btn btn-primary">{{ count($user->posts) }} <i
                            class="fa fa-clipboard" title="{{ str_plural('Post', count($user->posts)) }}"></i></a> <a
                        href="#" class="btn btn-primary">{{ count($user->replies) }} <i class="fa fa-comments"></i></a>
            </p>
        </div>
    </section>

    <div class="container">

        <div class="row">

            @foreach($user->posts as $post)
                <a class="card card-block col-md-4 p-0 cliackable" href="{{ $post->path() }}" style="display: block">
                    <img src="{{ $post->featured_image }}" class="card-img-top" alt="{{ $post->title }}">
                    <h4 class="card-title pl-3 pr-3 pt-2">{{ str_limit($post->title,$words = 48, $end='...') }}</h4>
                    <p class="card-text pl-3 pr-3 pb-2">{{ str_limit($post->body,$words = 100, $end='...') }}</p>
                </a>
            @endforeach
        </div>
    </div>
@stop