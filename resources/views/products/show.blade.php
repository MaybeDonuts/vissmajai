@extends('layouts.app')

@section('content')
    <h1>{{ $product->name }}</h1>
    <p><strong>Цена:</strong> {{ $product->price }} €</p>
    <p><strong>Описание:</strong> {{ $product->description }}</p>
    
    @if($product->image)
        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" width="300">
    @else
        <p>Нет изображения</p>
    @endif

    <br>
    <a href="{{ route('products.index') }}" class="btn btn-secondary">Назад к списку</a>
@endsection
