@extends('layouts.app')

@section('content')
    <h1>Категории</h1>
    <a href="{{ route('categories.create') }}" class="btn btn-primary">Добавить категорию</a>
    
    @if(session('success'))
        <p class="alert alert-success">{{ session('success') }}</p>
    @endif

    <ul>
        @foreach($categories as $category)
            <li>{{ $category->name }} 
                <form action="{{ route('categories.destroy', $category) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Удалить</button>
                </form>
            </li>
        @endforeach
    </ul>
@endsection
