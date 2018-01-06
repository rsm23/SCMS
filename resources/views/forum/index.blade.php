@extends('layouts.app')

@section('content')
    <div class="container mt-5" id="forum">
        <div class="row">
            @if (count($threads))
                @foreach($threads as $thread)
                    <div class="card mb-2" style="width: 100%">
                        <div class="card-body justify-content-between">
                            <a href="{{ $thread->path() }}"><h4
                                        class="card-title">{{ str_limit($thread->title,$words = 48, $end='...') }}</h4></a>
                            <h6 class="card-subtitle mb-2 text-muted">Posted {{ $thread->created_at->diffForHumans() }}</h6>
                            <p class="card-text">{{ str_limit($thread->body,$words = 100, $end='...') }}</p>
                        </div>
                        @can('update', $thread)
                            <div class="card-footer text-muted d-flex justify-content-between">
                                <a href="{{ route('forumPostEdit', [$thread->category, $thread]) }}" class="btn btn-success">Edit</a>
                                <form action="{{ route('forumPostDelete', [$thread->category, $thread]) }}" method="post" class="forumPostDelete" data-title="{{ $thread->title }}">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </div>
                        @endcan
                    </div>
                @endforeach
            @else
                <h1 class="text-center">Sorry, but there's nothing to show here</h1>
            @endif
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