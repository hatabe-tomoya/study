<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title')</title>
        <script src="{{ secure_asset('js/app.js') }}" defer></script>

        <link rel="dns-prefetch" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">
        <link href="{{ secure_asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ secure_asset('css/profile.css') }}" rel="stylesheet">
    </head>
    <body>
        <div id="app">
            
            <nav class="navbar navbar-expand-md navbar-dark navbar-laravel">
                <div class="container">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Study') }}
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav mr-auto">

                        </ul>

                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ml-auto">
                             <ul class="navbar-nav ml-auto">
                        {{-- ログインしていなかったらログイン画面へのリンクを表示 --}}
                        @guest
                            <li><a class="nav-link" href="{{ route('login') }}">{{ __('messages.Login') }}</a></li>
                            <li><a class="nav-link" href="#">{{ __('messages.Sign Up') }}</a></li>
                        {{-- ログインしていたらユーザー名とログアウトボタンを表示 --}}
                        @else
                            <nav class="navbar navbar-expand-sm navbar-dark bg-dark mt-3 mb-3">
                                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav4" aria-controls="navbarNav4" aria-expanded="false" aria-label="Toggle navigation"v-pre>
                                  <span class="navbar-toggler-icon"></span>
                                </button>
                                
                                <div class="collapse navbar-collapse justify-content-end">
                                    <ul class="navbar-nav">
                                        <li class="nav-item active">
                                            <a class="nav-link" href="#">勉強法一覧</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">勉強法作成</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#">{{ Auth::user()->name }} </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();"　href="{{ route('logout') }}">{{ __('messages.Logout') }}
                                            </a>
                                        </li>
                                    </ul>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </nav>
                            @endguest
                        </ul>
                    </div>
                </div>
            </nav>
           

            <main class="py-4">
               
                @yield('content')
            </main>
        </div>
    </body>
</html>