<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <<link href="https://fonts.googleapis.com/css2?family=Colibri&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Bolt&display=swap" rel="stylesheet">
<style>
    body {
        font-family: 'Colibri', sans-serif;
        color: black;
        background-color: white;
    }
    h1, h2, h3, h4 {
        font-family: 'Bolt', sans-serif;
    }
    .btn {
        font-size: 12px;
    }
</style>



    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('products.index') }}">Каталог</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('cart.show') }}">Корзина</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('products.discounted') }}">Скидки</a>
                        </li>

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">Войти</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">Регистрация</a>
                                </li>
                            @endif
                        @else
                        @if(auth()->check() && auth()->user()->isAdmin())
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.products') }}">Админка</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.users') }}">Пользователи</a>
    </li>
@endif

                            @if(auth()->user()->role === 'employee')
                                <a href="{{ route('admin.orders.new') }}" class="btn btn-warning">
                                    Новые заказы ({{ \App\Models\Order::where('viewed', false)->count() }})
                                </a>
                            @endif
                            @if(auth()->check())
                                <a href="{{ route('profile.index') }}" class="btn btn-secondary">Личный кабинет</a>
                            @endif
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('orders.history') }}">Мои заказы</a>
                            </li>

                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        Выйти
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                            
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
