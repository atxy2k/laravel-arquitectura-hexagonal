@extends('templates.layout')
@section('content')

<div class="text-right">
    <a href="{{ route('existencias.add') }}" class="btn btn-primary">Registrar nuevo movimiento</a>
</div>

<div class="card mt-3">
    <div class="card-header">Existencias</div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Marca</th>
                        <th>Departamento</th>
                        <th>Existencias totales</th>
                        @foreach ($almacenes as $almacen)
                            <th>Almacen: {{ $almacen->nombre }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                @forelse ($productos as $producto)
                    <tr>
                        <td>{{ $producto->id }}</td>
                        <td>
                            <div>
                                {{ $producto->nombre }} <small>(#{{$producto->codigo_barras}})</small>
                            </div>
                            <div>
                                <small>{{$producto->descripcion}}</small>
                            </div>
                        </td>
                        <td>{{ $producto->marca?->nombre }}</td>
                        <td>{{ $producto->departamento?->nombre }}</td>
                        <td>
                            {{ $producto->existencias->cantidad ?? 0 }}
                        </td>
                        @foreach ($almacenes as $almacen)
                            <td>
                                {{ $producto->existencias_por_almacen->where('almacen_id', $almacen->id)->first()->cantidad ?? 0 }}
                            </td>
                        @endforeach
                    </tr>
                @empty
                    <td>
                        <td colspan="{{ 5 + $almacenes->count() }}" class="text-center">Aún no ha registrado movimientos de inventario</td>
                    </td>
                @endforelse
            </tbody>
            </table>
        </div>
    </div>
</div>

@endsection