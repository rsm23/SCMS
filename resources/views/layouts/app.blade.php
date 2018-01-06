<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div id="app" class="pb-5">

    {{-- top bar  --}}
    <nav class="navbar navbar-expand-lg navbar-light">

        <div class="container">
            <a class="navbar-brand" href="#">{{ config('app.name', 'Laravel') }}</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <ul class="nav nav-pills">
                <li class="nav-item"><a href="{{ route('home') }}" class="nav-link">Home</a></li>
            </ul>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="nav nav-pills">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="{{ route('blog') }}" id="navbarDropdownMenuLink"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Blog
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <li><a href="{{ route('blog') }}" class="dropdown-item">Visit Blog</a></li>
                            @if (auth()->check())
                                <li><a href="{{ route('blogPostCreate') }}" class="dropdown-item">Create a blog post</a></li>
                                <li><a href="/blog?by={{ auth()->user()->name }}" class="dropdown-item">My Blog
                                        Posts</a></li>
                            @endif
                            <li class="dropdown-submenu"><a class="dropdown-item dropdown-toggle"
                                                            href="#">Categories</a>
                                <ul class="dropdown-menu">
                                    @foreach ($categories as $category)
                                        <li><a href="/blog/{{ $category->slug }}"
                                               class="dropdown-item">{{ $category->name }}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>

            <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                <ul class="nav nav-pills">
                    @if (Auth::guest())
                        <li class="nav-item"><a href="{{ route('login') }}" class="nav-link">Login</a></li>
                        <li class="nav-item"><a href="{{ route('register') }}" class="nav-link">Register</a></li>
                    @else
                        <li class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" id="navbarDropdownMenuLink"
                               data-toggle="dropdown"
                               aria-haspopup="true" aria-expanded="false">{{ Auth::user()->name }}</a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            @if (auth()->check())
                                <a href="/profiles/{{ auth()->user()->name }}" class="dropdown-item">Visit profile</a>
                            @endif
                        <a href="{{ route('logout') }}" class="dropdown-item"
                           onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                            Logout
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                              style="display: none;">
                            {{ csrf_field() }}
                        </form>
            </div>
            </li>
            @endif
            </ul>
        </div>
</div>

</nav>

<!-- Main Container -->
@yield('content')

</div>

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
<script>
    $('.dropdown-menu a.dropdown-toggle').on('click', function (e) {
        if (!$(this).next().hasClass('show')) {
            $(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
        }
        var $subMenu = $(this).next(".dropdown-menu");
        $subMenu.toggleClass('show');

        $(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function (e) {
            $('.dropdown-submenu .show').removeClass("show");
        });

        return false;
    });
</script>
@yield('footer')
</body>
</html>