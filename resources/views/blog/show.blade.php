@extends('layouts.app')

@section('content')
    <figure class="hero d-flex align-items-center justify-content-center" style="background: url('{{ $post->featured_image }}') no-repeat center center fixed;background-size: cover;">
        <h1 class="text-center">{{ $post->title }}</h1>
    </figure>
    <div class="container">
        <article>
            <editor value="{{ $post->body }}" :edit="false"></editor>
        </article>
    </div>
@stop