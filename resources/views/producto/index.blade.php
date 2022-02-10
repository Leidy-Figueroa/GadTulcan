@extends('layouts.app')

@section('content')
@if (auth()->user()->is_admin)
<a href="/productos/create" class="btn btn-sm btn-success">Agregar equipo tecnológico</a>
<a href="{{route('imprimir')}}" class="btn btn-sm btn-info">Imprimir reporte</a>
<a href="/export" class="btn btn-sm btn-warning">Exportar a Excel</a>
&nbsp;
<div class="panel panel-primary">
    <div class="panel-heading">Equipos tecnológicos</div>
    <div class="panel-body">
        @if (session('notification'))
    <div class="alert alert-success">
        {{ session('notification')}}
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
<form method="GET" action=" {{ route('productos') }}">
    {{ csrf_field() }} 
       {{--<input name="serie" class="form-control me-4" type="search" placeholder="Número de Serie" aria-label="Search">
        <button class="btn btn-outline-primary" type="submit">Buscar</button>
        </form> --}}

        <div style="overflow-x:auto;">
        <table class="table table-bordered">
        <thead class="bg-primary text-light">
                <tr>
                    <th scope="col">Detalles</th>
                    <th scope="col">Imagen</th>
                    <th scope="col">Serie</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Marca</th>
                    <th scope="col">Departamento</th>
                    <th scope="col">Acciones</th> 
                </tr>
            </thead>
            <tbody>
                @foreach($productos as $producto)
                <td><a href="/productos/{{ $producto->id }}/show" class="btn btn-sm btn-warning" title="Editar">Detalle</a></td>  
                    <td><img src="{{ asset('/storage/'.$producto->imagen) }}" width = "40" height = "40"></td>
                    <td>{{ $producto->serie}}</td>
                    <td>{{ $producto->descripcion}}</td>
                    @if ($producto->estados->nombre == "OPERATIVO")
                    <td bgcolor="#5D7B9D"><font color="#fff">{{ $producto->estados->nombre }}</td>
                    @else
                    <td>{{ $producto->estados->nombre }}</td>
                    @endif
                    <td>{{ $producto->marcas->nombre }}</td>
                    <td>{{ $producto->departamentos->nombre }}</td>
                    <td>
                        @if ($producto->trashed())                       
                        <a href="/productos/{{ $producto->id }}/restaurar" class="btn btn-sm btn-success" title="Restaurar">Restaurar
                        </a>
                        @else
                        <a href="/productos/{{ $producto->id }}/editar" class="btn btn-sm btn-primary" title="Editar">Editar
                        </a>
                        <a href="/productos/{{ $producto->id }}/eliminar" class="btn btn-sm btn-danger" title="Dar de baja">Eliminar
                        </a> 
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
  
@endif

@if (auth()->user()->is_support)

    <div class="panel panel-primary">
    <div class="panel-heading">Hacer uso de un equipo tecnologico</div>
    <div class="panel-body">
      {{-- <input class="form-control me-2" type="search" placeholder="Buscar" aria-label="Search">
      <button class="btn btn-outline-success" type="submit">Buscar</button> --}}
        <div style="overflow-x:auto;">
        <table class="table table-bordered">
        <thead class="bg-success text-light">
                <tr>
                    <th scope="col">Imagen</th>
                    <th scope="col">Serie</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Incidencia</th>
                    <th scope="col">Responsable</th>
                    <th scope="col">Departamento</th>
                    
                </tr>
            </thead>
            <tbody>
                @foreach($productos as $producto)
                    <td><img src="{{ asset('/storage/'.$producto->imagen) }}" width = "40" height = "40"></td>
                    <td>{{ $producto->serie}}</td>
                    <td>{{ $producto->descripcion}}</td>
                    @if ($producto->estados->nombre == "OPERATIVO")
                    <td bgcolor="#5D7B9D"><font color="#fff">{{ $producto->estados->nombre }}</td>
                    @else
                    <td>{{ $producto->estados->nombre }}</td>
                    <td><a href="/productos/{{ $producto->id }}/editar" class="btn btn-sm btn-primary" title="Editar">Usar</a></td> 
                    @endif
                    <td>{{ $producto->incidencia_id }}</td>
                    <td>{{ $producto->users->name }}</td> 
                    <td>{{ $producto->departamentos->nombre}}</td> 
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>
@method('PUT')
@endsection