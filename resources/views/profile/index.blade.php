@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Личный кабинет</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <h3>Обновление данных</h3>
    <form method="POST" action="{{ route('profile.update') }}">
        @csrf
        <label>Имя:</label>
        <input type="text" name="name" value="{{ $user->name }}" required class="form-control">

        <label>Телефон:</label>
        <input type="text" name="phone" value="{{ $user->phone }}" class="form-control">

        <label>Адрес доставки:</label>
        <input type="text" name="address" value="{{ $user->address }}" class="form-control">

        <button type="submit" class="btn btn-primary mt-2">Сохранить</button>
    </form>

    <hr>

    <h3>Смена пароля</h3>
    <form method="POST" action="{{ route('profile.password') }}">
        @csrf
        <label>Текущий пароль:</label>
        <input type="password" name="current_password" required class="form-control">

        <label>Новый пароль:</label>
        <input type="password" name="password" required class="form-control">

        <label>Подтвердите новый пароль:</label>
        <input type="password" name="password_confirmation" required class="form-control">

        <button type="submit" class="btn btn-warning mt-2">Изменить пароль</button>
    </form>
    <hr>
</div>
@endsection
