@extends('layout.layout')

@section('content')

<div class="card">

    <div class="card-header">
        Honorarios Municipales - Ingreso de Nuevo Funcionario.
    </div>

    <div class="card-body">
        <form action="{{ route('funcionario.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
            <div class="container">
                <div class="mb-12">
                    <label for="exampleFormControlInput1" class="form-label">Nombre Funcionario</label>
                    <input type="text" class="form-control" name="nombre_funcionario" placeholder="Nombre Funcionario">
                </div>
                <div class="mb-12">
                    <label for="exampleFormControlInput1" class="form-label">Rut Funcionario</label>
                    <input type="text" class="form-control" name="rut_funcionario" placeholder="Rut Funcionario">
                    </select>
                </div>
                <div class="mb-12">
                    <label for="exampleFormControlInput1" class="form-label">Fecha de ingreso</label>
                    <input type="date" class="form-control" name="fecha_ingreso" placeholder="Fecha de ingreso">
                </div>
                <div class="mb-12">
                    <label for="formFile" class="form-label">Fecha de término</label>
                    <input type="date" class="form-control" name="fecha_termino" placeholder="Fecha de término">
                </div>
                <br>
            </div>
    </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Agregar</button>
                <a href="{{ route('honorario.create') }}" class="btn btn-secondary">Volver</a>
            </div>
        </form>

@endsection
