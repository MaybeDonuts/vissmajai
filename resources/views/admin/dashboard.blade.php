@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Админ-панель</h1>

        <div class="row">
            <div class="col-md-4">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-header">Пользователи</div>
                    <div class="card-body">
                        <h4 class="card-title">{{ $usersCount }}</h4>
                        <a href="{{ route('admin.users') }}" class="btn btn-light">Управление</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card text-white bg-success mb-3">
                    <div class="card-header">Заказы</div>
                    <div class="card-body">
                        <h4 class="card-title">{{ $ordersCount }}</h4>
                        <a href="{{ route('admin.orders') }}" class="btn btn-light">Просмотр</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card text-white bg-warning mb-3">
                    <div class="card-header">Товары</div>
                    <div class="card-body">
                        <h4 class="card-title">{{ $productsCount }}</h4>
                        <a href="{{ route('products.index') }}" class="btn btn-light">Каталог</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
