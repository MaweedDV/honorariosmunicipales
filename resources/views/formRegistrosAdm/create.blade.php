@extends('layout.layout')

@section('content')

<div class="card">

    <div class="card-header">
        Honorarios Municipales - Ingreso de Nuevo Informe de Pago.
    </div>

    <div class="card-body">
        <a href="{{ route('funcionario.create') }}" class="btn btn-primary mb-3">Registrar Nuevo Funcionario</a>
        <form action="{{ route('honorario.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
            <div class="container">
                <div class="mb-12">
                    <label for="exampleFormControlInput1" class="form-label">Funcionario</label>
                    <select class="form-select" aria-label="Default select example" name="funcionario_id">
                        <option selected>Seleccione Funcionario</option>
                        @foreach ( $funcionarios as $funcionario)
                            <option value="{{ $funcionario->id }}">{{ $funcionario->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-12">
                    <label for="exampleFormControlInput1" class="form-label">Año Registro</label>
                    <select class="form-select" aria-label="Default select example" name="ano_registro">
                        <option selected>Seleccione Año</option>
                        <option value="2023">2023</option>
                        <option value="2024">2024</option>
                        <option value="2025">2025</option>
                        <option value="2026">2026</option>
                        <option value="2027">2027</option>
                        <option value="2029">2029</option>
                        <option value="2030">2030</option>
                        <option value="2028">2028</option>
                    </select>
                </div>
                <div class="mb-12">
                    <label for="exampleFormControlInput1" class="form-label">Mes de Pago</label>
                    <select class="form-select" aria-label="Default select example" name="mes_pago">
                        <option selected>Seleccione Mes</option>
                        <option value="Febrero">Febrero</option>
                        <option value="Enero">Enero</option>
                        <option value="Marzo">Marzo</option>
                        <option value="Abril">Abril</option>
                        <option value="Mayo">Mayo</option>
                        <option value="Junio">Junio</option>
                        <option value="Julio">Julio</option>
                        <option value="Agosto">Agosto</option>
                        <option value="Septiembre">Septiembre</option>
                        <option  value="Octubre">Octubre</option>
                        <option  value="Noviembre">Noviembre</option>
                        <option  value="Diciembre">Diciembre</option>
                    </select>
                </div>
                <div class="mb-12">
                    <label for="exampleFormControlInput1" class="form-label">Valor Pagado</label>
                    <input type="text" class="form-control" name="valor_pagado" placeholder="$ 0.000.000">
                </div>
                <div class="mb-12">
                    <label for="formFile" class="form-label">Subir PDF</label>
                    <input class="form-control" type="file" id="pdf_honorario" name="pdf_honorario" accept=".pdf">
                </div>
                <br>
            </div>
    </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Agregar</button>
                <a href="{{ route('honorario.indexForm') }}" class="btn btn-danger">Cancelar</a>
            </div>
        </form>

@endsection
