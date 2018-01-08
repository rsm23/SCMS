@extends('layouts.app')

@section('content')
    
    <div class="container mt-5">
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="post" action="{{ route('forumThreadUpdate', [$thread->category, $thread->slug]) }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            {{ method_field('PATCH') }}


            <div class="form-row">
                <div class="col">
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" class="form-control" id="title" name="title" aria-describedby="titleHelp"
                               placeholder="Your Title Here" value="{{ old('title') ?: $thread->title }}">
                        <small id="titleHelp" class="form-text text-muted">Should be more than 4 characters</small>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="category_id">Category</label>
                        <select name="category_id" id="category_id" class="form-control" required>
                            <option value="">Choose One...</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ $thread->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        <small id="titleHelp" class="form-text text-muted">The category is obligatory</small>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Body</label>
                <editor value="{{ old('body') ?: $thread->body }}" edit="true"></editor>
                <small id="titleHelp" class="form-text text-muted">Can not be empty!</small>
            </div>

            <button type="submit" class="btn btn-primary">Update Post</button>
        </form>
    </div>
@stop