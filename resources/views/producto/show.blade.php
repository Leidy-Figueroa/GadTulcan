@extends('layouts.app')
@section('content')
  <div class="panel panel-primary">
    <div class="panel-heading">Detalle del equipo tecnólogico</div>
    <div class="panel-body">
<div class="card mb-3" style="max-width: 540px;">
  <div class="row no-gutters">
    <div class="col-md-4">
      <img src="/storage/{{$producto->imagen}}"   width="150" height="150" >
    </div>
    <div class="col-md-8">
      <div class="card-body">
        <p class="card-text">
        <small>
                    <li><strong>Serie: </strong>{{$producto->serie}}</li>
                    <li><strong>Fecha Ingreso: </strong>{{$producto->fecha_ingreso}}</li>
                    <li><strong>Fecha de actualización: </strong>{{$producto->updated_at}}</li>
                    <li><strong>Marca: </strong>{{$producto->marcas->nombre}}</li>
                    <li><strong>Modelo: </strong>{{$producto->modelos->nombre}}</li>
        </small>
                  <div class="alert alert-dismissible alert-success">
                  <li><strong>Estado: </strong>{{$producto->estados->nombre}}</li>
                  <li><strong>Numero de la incidencia atentida: </strong>{{$producto->incidencia_id}}</li>
                  <li><strong>Responsable: </strong>{{$producto->users->name}}</li>
                  <li><strong>Departamento: </strong>{{$producto->departamentos->nombre}}</li>
                  
       
    </div>
  </div>
@endsection