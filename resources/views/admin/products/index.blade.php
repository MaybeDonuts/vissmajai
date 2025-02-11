@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Управление товарами</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Кнопка для добавления нового товара -->
    @if(auth()->user()->isAdmin() || auth()->user()->isEmployee())
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">Добавить товар</a>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Название</th>
                <th>Цена</th>
                <th>Склад</th>
                <th>Скидка</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->price }} €</td>
                    <td>{{ $product->stock }}</td>
                    <td>{{ $product->discount ? $product->discount . '%' : 'Нет' }}</td>
                    <td>
                    <td>
    @can('manage-products')
        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-warning btn-sm">Редактировать</a>
    @endcan
</td>



    @can('delete-products')
        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm">Удалить</button>
        </form>
    @endcan
</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $products->links() }}
</div>
@endsection
