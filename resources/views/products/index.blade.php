@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Список товаров</h1>

    <!-- Кнопка для добавления нового товара -->
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">Добавить товар</a>

    <!-- Фильтры и сортировка -->
    <form method="GET" action="{{ route('products.index') }}" class="mb-3">
        <div class="row">
            <div class="col-md-2">
                <label for="category">Фильтр по категории:</label>
                <select name="category" id="category" class="form-control">
                    <option value="">Все категории</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label for="price_from">Цена от:</label>
                <input type="number" name="price_from" id="price_from" class="form-control" placeholder="Минимальная цена" value="{{ request('price_from') }}">
            </div>
            <div class="col-md-2">
                <label for="price_to">Цена до:</label>
                <input type="number" name="price_to" id="price_to" class="form-control" placeholder="Максимальная цена" value="{{ request('price_to') }}">
            </div>
            <div class="col-md-3">
                <label for="name">Поиск по названию:</label>
                <input type="text" name="name" id="name" class="form-control" placeholder="Введите название товара" value="{{ request('name') }}">
            </div>
            <div class="col-md-2">
                <label for="discounted" class="form-label">Со скидками</label>
                <input type="checkbox" name="discounted" id="discounted" {{ request('discounted') ? 'checked' : '' }}>
            </div>

            <div class="col-md-2">
                <label for="sort">Сортировать по:</label>
                <select name="sort" id="sort" class="form-control">
                    <option value="">Без сортировки</option>
                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Цена (по возрастанию)</option>
                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Цена (по убыванию)</option>
                    <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Название (А-Я)</option>
                    <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Название (Я-А)</option>
                </select>
            </div>
        </div>
        <div class="mt-3">
            <button type="submit" class="btn btn-primary">Применить</button>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Сбросить</a>
        </div>
    </form>

    <!-- Таблица товаров -->
    <table class="table">
        <thead>
            <tr>
                <th>Название</th>
                <th>Категория</th>
                <th>Цена</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->category->name ?? 'Без категории' }}</td>
                    <td>{{ $product->price }} €</td>
                    <td>
                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-info btn-sm">Подробнее</a>
                        @if(auth()->check() && (auth()->user()->isAdmin() || auth()->user()->isEmployee()))
                            <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-warning btn-sm">Редактировать</a>
                        @endif
                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Удалить</button>
                        </form>
                        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm" {{ $product->stock <= 0 ? 'disabled' : '' }}>
                                В корзину
                            </button>
                        </form>
                    </td>
                    <td>
    @if($product->discount > 0 && 
        (is_null($product->discount_start) || $product->discount_start <= now()) && 
        (is_null($product->discount_end) || $product->discount_end >= now()))
        <span class="text-danger">
            {{ number_format($product->price * (1 - $product->discount / 100), 2) }} €
        </span>
        <small class="text-muted"><del>{{ number_format($product->price, 2) }} €</del></small>
    @else
        {{ number_format($product->price, 2) }} €
    @endif
</td>

                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Пагинация -->
    {{ $products->links() }}
</div>
@endsection
