@extends('layouts.app')

@section('content')
<div class="panel panel-primary">
    <div class="panel-heading">Crear usuarios de soporte</div>
        <div class="panel-body">
        @if (session('notification'))
            <div class="alert alert-success">
                {{ session('notification') }}
            </div>
        @endif

@if (count($errors) > 0 )
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <form action="" method="POST">
        {{ csrf_field() }}
        <div class="row mb-3">
            <label for="email" class="col-md-4 col-form-label text-md-end">Correo Electrónico</label>
            <div class="col-md-6">
            <input type="email" name="email" class="form-control" value="{{ old('title') }}">
        </div>
        </div>
        <div class="row mb-3">
            <label for="name" class="col-md-4 col-form-label text-md-end">Nombre</label>
            <div class="col-md-6">
            <input type="text" name="name" class="form-control" value="{{ old('name') }}">
        </div>
        </div>
        <div class="row mb-3">
            <label for="password"class="col-md-4 col-form-label text-md-end">Contraseña</label>
            <div class="col-md-6">
            <input type="text" name="password" class="form-control" value="{{ old('password', Str::random(8)) }}">
        </div>
        </div>
        &nbsp;
        <div class="row mb-0">
         <div class="col-md-8 offset-md-4">
            <button class="btn btn-success">Registrar usuario</button>
        </div>
        </div>
    </form>
    &nbsp;
        <table class="table table-bordered">
        <thead class="bg-primary">
                <tr>
                    <th>#</th>
                    <th>E-mail</th>
                    <th>Nombre</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->name }}</td>
                    <td><a href="/usuario/{{ $user->id }}" class="btn btn-sm btn-primary" title="Editar">Editar
                    <a href="/usuario/{{ $user->id }}/eliminar" class="btn btn-sm btn-danger" title="Dar de baja">Eliminar</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@method('PUT')
@endsection