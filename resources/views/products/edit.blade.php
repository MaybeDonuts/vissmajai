@extends('layouts.app')

@section('content')
    <h1>Редактировать товар</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>

        <div class="mb-3">
            <label for="discount" class="form-label">Скидка (%)</label>
            <input type="number" name="discount" id="discount" class="form-control" value="{{ old('discount', $product->discount) }}">
        </div>

        <div class="mb-3">
            <label for="discount_start" class="form-label">Начало скидки</label>
            <input type="datetime-local" name="discount_start" id="discount_start" class="form-control" value="{{ old('discount_start', $product->discount_start ? $product->discount_start->format('Y-m-d\TH:i') : '') }}">
        </div>

        <div class="mb-3">
            <label for="discount_end" class="form-label">Конец скидки</label>
    <       input type="datetime-local" name="discount_end" id="discount_end" class="form-control" value="{{ old('discount_end', $product->discount_end ? $product->discount_end->format('Y-m-d\TH:i') : '') }}">
        </div>


    @endif

    <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <label>Название:</label>
        <input type="text" name="name" value="{{ $product->name }}" required>

        <label>Описание:</label>
        <textarea name="description">{{ $product->description }}</textarea>

        <label>Цена:</label>
        <input type="text" name="price" value="{{ $product->price }}" required>

        <label>Количество:</label>
        <input type="number" name="stock" value="{{ $product->stock }}" required>

        

        <label>Категория:</label>
        <select name="category_id">
            <option value="">Выберите категорию</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>

        <label>Изображение:</label>
        @if ($product->image)
            <img src="{{ asset('storage/' . $product->image) }}" width="100">
        @endif
        <input type="file" name="image">

        <button type="submit">Сохранить</button>
    </form>

    <br>
    <a href="{{ route('products.index') }}" class="btn btn-secondary">Назад к списку</a>
@endsection
