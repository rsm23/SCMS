@extends('layouts.app')

@section('content')
    <figure class="hero d-flex align-items-center justify-content-center"
            style="background: url('{{ $post->featured_image }}') no-repeat center center fixed;background-size: cover;">
        <h2 class="text-center">Editing : {{ $post->title }}</h2>
    </figure>
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
        
        <form method="post" action="{{ route('blogPostUpdate', [$post->category, $post->slug]) }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            {{ method_field('PATCH') }}

            <div class="form-group">
                <label>Featured Image</label>
                <div class="input-group">
            <span class="input-group-btn">
                <span class="btn btn-primary btn-file">
                    Browse… <input type="file" id="featured_image" name="featured_image" accept="image/x-png,image/gif,image/jpeg">
                </span>
            </span>
                    <input type="text" class="form-control" readonly title="Featured Image">
                </div>
            </div>

            <div class="form-row">
                <div class="col">
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" class="form-control" id="title" name="title" aria-describedby="titleHelp"
                               placeholder="Your Title Here" value="{{ old('title') ?: $post->title }}">
                        <small id="titleHelp" class="form-text text-muted">Should be more than 4 characters</small>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <label for="category_id">Category</label>
                        <select name="category_id" id="category_id" class="form-control" required>
                            <option value="">Choose One...</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ $post->category_id == $category->id ? 'selected' : '' }}>
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
                <editor value="{{ old('body') ?: $post->body }}" edit="true"></editor>
                <small id="titleHelp" class="form-text text-muted">Can not be empty!</small>
            </div>

            <button type="submit" class="btn btn-primary">Update Post</button>
        </form>
    </div>
@stop

@section('footer')
    <script>
        $(document).ready(function () {
            $(document).on('change', '.btn-file :file', function () {
                let input = $(this),
                    label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
                input.trigger('fileselect', [label]);
            });

            $('.btn-file :file').on('fileselect', function (event, label) {

                let input = $(this).parents('.input-group').find(':text'),
                    log = label;

                if (input.length) {
                    input.val(log);
                } else {
                    if (log) alert(log);
                }

            });

            function readURL(input) {
                if (input.files && input.files[0]) {
                    let reader = new FileReader();

                    reader.onload = function (e) {
                        $('figure.hero').css('background', 'url(' + e.target.result + ') no-repeat center center fixed')
                            .css('background-size', 'cover');
                    };

                    reader.readAsDataURL(input.files[0]);
                }
            }

            $("#featured_image").change(function () {
                readURL(this);
            });
        });
    </script>
@stop