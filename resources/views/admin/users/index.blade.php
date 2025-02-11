@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Управление пользователями</h1>

    <table class="table">
        <thead>
            <tr>
                <th>Имя</th>
                <th>Email</th>
                <th>Роль</th>
                <th>Статус</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
    <form action="{{ route('admin.users.updateRole', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        <select name="role" onchange="this.form.submit()" class="form-select">
            <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>Пользователь</option>
            <option value="employee" {{ $user->role == 'employee' ? 'selected' : '' }}>Сотрудник</option>
            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Администратор</option>
        </select>
    </form>
</td>

                    <td>{{ $user->is_blocked ? 'Заблокирован' : 'Активен' }}</td>
                    <td>
                        <form action="{{ route('admin.users.block', $user->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-sm {{ $user->is_blocked ? 'btn-success' : 'btn-danger' }}">
                                {{ $user->is_blocked ? 'Разблокировать' : 'Заблокировать' }}
                            </button>
                        </form>
                    </td>
                    <td>
    <form action="{{ route('admin.users.updateRole', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        <select name="role" onchange="this.form.submit()" class="form-select">
            <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>Пользователь</option>
            <option value="employee" {{ $user->role == 'employee' ? 'selected' : '' }}>Сотрудник</option>
            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Администратор</option>
        </select>
    </form>
</td>

                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $users->links() }}
</div>
@endsection
