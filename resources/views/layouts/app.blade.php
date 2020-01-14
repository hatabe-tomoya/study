<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Study') }}</title>

    
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        

    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">


    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Study') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto">
                        {{-- ログインしていなかったらログイン画面へのリンクを表示 --}}
                        @guest
                            <li><a class="nav-link" href="{{ route('login') }}">{{ __('messages.Login') }}</a></li>
                            <li><a class="nav-link" href="{{ route('register') }}">新規登録</a></li>
                        {{-- ログインしていたらユーザー名とログアウトボタンを表示 --}}
                        @else
                            <nav class="navbar navbar-expand-sm  mt-3 mb-3">
                                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav4" aria-controls="navbarNav4" aria-expanded="false" aria-label="Toggle navigation"v-pre>
                                  <span class="navbar-toggler-icon"></span>
                                </button>
                                
                                <div class="collapse navbar-collapse justify-content-end">
                                    <ul class="navbar-nav">
                                        <li class="nav-item ">
                                            <a class="nav-link" href="{{url('posts/')}}">勉強法一覧</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{url('posts/create')}}">勉強法作成</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ url('users/' .Auth::user()->id) }}">{!! nl2br(e(str_limit(Auth::user()->name, 20))) !!} </a>
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
        @if (session('change_password_success'))
            <div class="alert alert-success">
                {{ session('change_password_success') }}
            </div>
        @endif
        @if (session('update_account_success'))
            <div class="alert alert-success">
                {{ session('update_account_success') }}
            </div>
        @endif   
        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
