@extends('layouts.app')

@section('content')
    <figure class="jumbotron d-flex align-items-center justify-content-center">
        <h2 class="text-center" id="title">Create a new blog post</h2>
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

        <form method="post" action="{{ route('blogPostStore') }}" enctype="multipart/form-data">
            {{ csrf_field() }}

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

            <div class="form-group">
                <label>Title</label>
                <input type="text" class="form-control" id="title" name="title" aria-describedby="titleHelp"
                       placeholder="Your Title Here" value="{{ old('title') }}">
                <small id="titleHelp" class="form-text text-muted">Should be more than 4 characters</small>
            </div>

            <div class="form-group">
                <label>Body</label>
                <editor value="{{ old('body') ?:  'I support **Markdown**!' }}" edit="true"></editor>
                <small id="titleHelp" class="form-text text-muted">Can not be empty!</small>
            </div>

            <button type="submit" class="btn btn-primary">Create Post</button>
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
                        $('figure.jumbotron').css('background', 'url(' + e.target.result + ') no-repeat center center fixed')
                            .css('background-size', 'cover');
                        $('#title').addClass('text-light');
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