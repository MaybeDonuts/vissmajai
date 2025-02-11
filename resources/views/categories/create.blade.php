@extends('layouts.app')

@section('content')
    <h1>Добавить категорию</h1>
    <form action="{{ route('categories.store') }}" method="POST">
        @csrf
        <input type="text" name="name" placeholder="Название категории" required>
        <button type="submit">Добавить</button>
    </form>
@endsection
