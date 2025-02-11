@extends('layouts.app')

@section('content')
    <h1>Добавить товар</h1>
    
    <form action="{{ route('products.store') }}" method="POST">
        @csrf
        <label>Название товара:</label>
        <input type="text" name="name" required>
        
        <label>Описание:</label>
        <textarea name="description"></textarea>
        
        <label>Цена:</label>
        <input type="text" name="price" required>
        
        <label>Количество:</label>
        <input type="number" name="stock" required>
        
        <div class="mb-3">
            <label for="discount" class="form-label">Скидка (%)</label>
            <input type="number" name="discount" id="discount" class="form-control" value="{{ old('discount') }}">
        </div>

        <div class="mb-3">
            <label for="discount_start" class="form-label">Начало скидки</label>
            <input type="datetime-local" name="discount_start" id="discount_start" class="form-control" value="{{ old('discount_start') }}">
        </div>

        <div class="mb-3">
            <label for="discount_end" class="form-label">Конец скидки</label>
            <input type="datetime-local" name="discount_end" id="discount_end" class="form-control" value="{{ old('discount_end') }}">
        </div>

        
        <label>Категория:</label>
        <select name="category_id">
            <option value="">Выберите категорию</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
        
        <button type="submit">Добавить</button>
    </form>
@endsection
