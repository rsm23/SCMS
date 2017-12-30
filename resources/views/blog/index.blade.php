@extends('layouts.app')

@section('content')
    <div class="container mt-5" id="blog">
        <div class="row">
            @foreach($posts as $post)
                <div class="card col-md-4 d-inline-block" style="padding: 0;">
                    <img class="card-img-top" src="{{ $post->featured_image }}" alt="{{ $post->title }}" width="350"
                         height="180">
                    <div class="card-body justify-content-between">
                        <a href="/blog/{{ $post->slug }}"><h4
                                    class="card-title">{{ str_limit($post->title,$words = 48, $end='...') }}</h4></a>
                        <p class="card-text">{{ str_limit($post->body,$words = 100, $end='...') }}</p>
                        <a href="/blog/{{ $post->slug }}" class="btn btn-primary">Read More</a>
                    </div>
                    @can('update', $post)
                        <div class="card-footer text-muted d-flex justify-content-between">
                            <a href="{{ route('blogPostEdit', $post) }}" class="btn btn-success">Edit</a>
                            <form action="{{ route('blogPostDelete', $post) }}" method="post" class="blogPostDelete" data-title="{{ $post->title }}">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </div>
                    @endcan
                </div>
            @endforeach
        </div>
    </div>
@endsection

@section('footer')
    <script>
        let formsCollection = document.getElementsByTagName("form");
            for(let i=0;i<formsCollection.length;i++)
            {
                formsCollection[i].onsubmit = function () {
                return window.confirm('Are you sure that you want to delete : ' + formsCollection[i].getAttribute('data-title') + '?');
            }
        }
    </script>
@stop