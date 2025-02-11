@extends('layouts.admin')

@section('content')
<h2>Редактирование скидки для {{ $product->name }}</h2>

<form action="{{ route('admin.update-discount', $product->id) }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="discount">Скидка (%)</label>
        <input type="number" name="discount" value="{{ $product->discount }}" class="form-control" min="0" max="100">
    </div>

    <div class="mb-3">
        <label for="discount_start">Начало скидки</label>
        <input type="datetime-local" name="discount_start" value="{{ $product->discount_start }}" class="form-control">
    </div>

    <div class="mb-3">
        <label for="discount_end">Конец скидки</label>
        <input type="datetime-local" name="discount_end" value="{{ $product->discount_end }}" class="form-control">
    </div>

    <button type="submit" class="btn btn-primary">Сохранить</button>
</form>
@endsection
