@extends('templates.layout')
@section('content')

<div class="text-right">
    <a href="{{ route('productos.add') }}" class="btn btn-primary">Agregar producto</a>
</div>

<div class="card mt-3">
    <div class="card-header">Productos</div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Marca</th>
                        <th>Departamento</th>
                        <th>Registrado por</th>
                        <th>Última actualización por</th>
                        <th>Acciones</th>
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
                        <td>{{ !is_null($producto->marca) ? $producto->marca->nombre : '-' }}</td>
                        <td>{{ !is_null($producto->departamento) ? $producto->departamento->nombre : '-' }}</td>
                        <td>
                            <div>{{ $producto->created_by->name }}</div>
                            <div>{{ $producto->created_at->fromNow() }}</div>
                        </td>
                        <td>
                            <div>{{ $producto->updated_by->name }}</div>
                            <div>{{ $producto->updated_at->fromNow() }}</div>
                        </td>
                        <td>
                            @can('change product')
                                <a href="{{ route('productos.change', $producto->id) }}" class="btn btn-primary">Editar</a>
                            @endcan
                            @can('delete product')
                                <a href="{{ route('productos.delete', $producto->id) }}" class="btn btn-danger">Eliminar</a>
                            @endcan
                        </td>
                    </tr>
                @empty
                    <td>
                        <td colspan="7" class="text-center">Aún no ha registrado elementos</td>
                    </td>
                @endforelse
            </tbody>
            </table>
        </div>
    </div>
</div>

@endsection