@extends('layout.layout')

@section('content')

<!-- Código de depuración - ELIMINAR DESPUÉS -->


<div class="card">
    <div class="card-header">
        Honorarios Municipales - Informes de Pagos.
    </div>

    <div class="card-body">
        <a href="{{ route('honorario.create') }}" class="btn btn-primary mb-3">Registrar Nuevo Pago</a>

        <!-- Buscador -->
        <div class="row mb-3">
            <div class="col-md-6">
                <input type="text" id="buscador" class="form-control" placeholder="Buscar por nombre o rut...">
            </div>
            <div class="col-md-6 text-end">
                <span id="totalRegistros" class="badge bg-secondary"></span>
            </div>
        </div>

        <!-- Tabla de resultados -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="tablaPagos">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre Funcionario</th>
                        <th>Rut Funcionario</th>
                        <th>Mes de Pago</th>
                        <th>Año de Registro</th>
                        <th>Valor Pagado</th>
                        <th>PDF</th>
                    </tr>
                </thead>
                <tbody id="tablaBody">
                    @forelse ($pagos as $pago)
                    <tr>
                        <td>{{ $pago->id }}</td>
                        <td>{{ $pago->funcionario->nombre }}</td>
                        <td>{{ $pago->funcionario->rut }}</td>
                        <td>{{ $pago->mes_pago }}</td>
                        <td>{{ $pago->ano_registro }}</td>
                        <td>$ {{ number_format($pago->valor_pagado, 0, ',', '.') }}</td>
                        <td>
                            @if($pago->id)
                               <a href="{{ route('ver.pdf', $pago->id) }}">
                                    <i class="bi bi-file-pdf-fill" style="font-size: 1.5rem; color: #dc3545;"></i>
                                </a>
                            @else
                                <span class="text-muted">Sin PDF</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr id="filaVacia">
                        <td colspan="6" class="text-center">No hay pagos registrados</td>
                    </tr>

                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mensaje cuando no hay resultados -->
        <div id="sinResultados" class="alert alert-warning text-center" style="display: none;">
            <i class="bi bi-search"></i> No se encontraron resultados para "<span id="terminoBuscado"></span>"
        </div>

        <div class="container text-center">
            <!-- Aquí tu contenido adicional -->
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Esperar a que todo el DOM esté cargado
    document.addEventListener('DOMContentLoaded', function() {
        console.log('✅ DOM cargado correctamente');

        // Obtener elementos del DOM
        const buscador = document.getElementById('buscador');
        const tablaBody = document.getElementById('tablaBody');
        const sinResultados = document.getElementById('sinResultados');
        const terminoBuscado = document.getElementById('terminoBuscado');
        const totalRegistros = document.getElementById('totalRegistros');

        // Verificar que los elementos existen
        if (!buscador) {
            console.error('❌ No se encontró el elemento #buscador');
            return;
        }

        console.log('✅ Buscador encontrado:', buscador);

        // Obtener todas las filas de la tabla (excluyendo la fila de "No hay pagos")
        const filas = Array.from(tablaBody.querySelectorAll('tr'))
            .filter(fila => !fila.querySelector('td[colspan]'));

        console.log(`✅ ${filas.length} filas encontradas para filtrar`);

        // Función de búsqueda
        function buscar() {
            const texto = buscador.value.toLowerCase().trim();
            console.log(`🔍 Buscando: "${texto}"`);

            let visibles = 0;

            // Ocultar mensaje de "sin resultados" por defecto
            sinResultados.style.display = 'none';

            // Si no hay filas, mostrar mensaje
            if (filas.length === 0) {
                tablaBody.style.display = 'none';
                totalRegistros.textContent = 'No hay registros';
                return;
            }

            // Recorrer cada fila
            filas.forEach(function(fila, index) {
                const celdas = fila.querySelectorAll('td');

                // Si no tiene celdas, ocultar
                if (celdas.length < 2) {
                    fila.style.display = 'none';
                    return;
                }

                // Obtener texto de nombre (columna 0) y rut (columna 1)
                const nombre = celdas[0]?.textContent.toLowerCase() || '';
                const rut = celdas[1]?.textContent.toLowerCase() || '';

                // Verificar si coincide con la búsqueda
                const coincide = nombre.includes(texto) || rut.includes(texto);

                if (coincide) {
                    fila.style.display = '';
                    visibles++;
                } else {
                    fila.style.display = 'none';
                }
            });

            // Mostrar mensaje si no hay resultados
            if (visibles === 0 && texto !== '') {
                sinResultados.style.display = 'block';
                terminoBuscado.textContent = texto;
                tablaBody.style.display = 'none';
            } else {
                sinResultados.style.display = 'none';
                tablaBody.style.display = '';
            }

            // Actualizar contador
            if (totalRegistros) {
                totalRegistros.textContent = `Mostrando ${visibles} de ${filas.length} registros`;
            }

            console.log(`📊 Resultados: ${visibles} de ${filas.length}`);
        }

        // Evento de búsqueda en tiempo real
        buscador.addEventListener('input', buscar);
        console.log('✅ Evento input agregado al buscador');

        // Limpiar con tecla ESC
        buscador.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                this.value = '';
                buscar();
                this.blur();
            }
        });

        // Inicializar contador
        if (totalRegistros) {
            totalRegistros.textContent = `Total: ${filas.length} registros`;
        }

        // Forzar una búsqueda inicial para mostrar el estado
        buscar();

        console.log('✅ Script inicializado correctamente');
    });
</script>
@endpush
