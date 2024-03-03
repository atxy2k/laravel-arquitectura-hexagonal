@extends('templates.layout')
@section('content')

<div class="card mt-3">
    <div class="card-header">Kardex - Movimientos de inventario</div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Producto</th>
                        <th>Almacen</th>
                        <th>Tipo de movimiento</th>
                        <th>Cantidad anterior</th>
                        <th>Cantidad en el movimiento</th>
                        <th>Cantidad posterior</th>
                        <th>Responsable</th>
                    </tr>
                </thead>
                <tbody>
                @forelse ($movimientos as $movimiento)
                    <tr>
                        <td>{{ $movimiento->id }}</td>
                        <td>{{ $movimiento->producto->nombre ?? 'No disponible' }}</td>
                        <td>{{ $movimiento->almacen->nombre ?? 'No disponible' }}</td>
                        <td>
                            @if($movimiento->tipo_movimiento === App\Models\Movimiento::ENTRADA)
                                <span class="badge badge-success">Entrada</span>
                            @else
                                <span class="badge badge-danger">Salida</span>
                            @endif
                        </td>
                        <td>{{ $movimiento->cantidad_anterior }}</td>
                        <td>{{ $movimiento->cantidad }}</td>
                        <td>{{ $movimiento->cantidad_posterior }}</td>
                        <td>{{ $movimiento->created_by->name ?? 'No disponible' }}</td>
                    </tr>
                @empty
                    <td>
                        <td colspan="8" class="text-center">Aún no ha registrado elementos</td>
                    </td>
                @endforelse
            </tbody>
            </table>
        </div>
    </div>
</div>

@endsection