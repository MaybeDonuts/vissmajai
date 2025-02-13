@extends('layouts.app')

@section('content')
    <h2>Популярные товары</h2>
    <div class="row">
        @foreach ($popularProducts as $product)
            <div class="col-md-3">
                <div class="product-card">
                    <img src="{{ $product->image }}" class="img-fluid" alt="{{ $product->name }}">
                    <h4>{{ $product->name }}</h4>
                    <p><strong>{{ $product->price }} €</strong></p>
                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary">Подробнее</a>
                </div>
            </div>
        @endforeach
    </div>
@endsection
