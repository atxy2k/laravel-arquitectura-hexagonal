@extends('templates.layout')
@section('content')

<div class="text-right">
    <a href="{{ route('almacenes.add') }}" class="btn btn-primary">Agregar almacen</a>
</div>

<div class="card mt-3">
    <div class="card-header">Almacenes</div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Registrado por</th>
                        <th>Última actualización por</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                @forelse ($almacenes as $almacen)
                    <tr>
                        <td>{{ $almacen->id }}</td>
                        <td>{{ $almacen->nombre }}</td>
                        <td>
                            <div>{{ $almacen->created_by->name }}</div>
                            <div>{{ $almacen->created_at->fromNow() }}</div>
                        </td>
                        <td>
                            <div>{{ $almacen->updated_by->name }}</div>
                            <div>{{ $almacen->updated_at->fromNow() }}</div>
                        </td>
                        <td>
                            <a href="{{ route('almacenes.change', $almacen->id) }}" class="btn btn-primary">Editar</a>
                            <a href="{{ route('almacenes.delete', $almacen->id) }}" class="btn btn-danger">Eliminar</a>
                        </td>
                    </tr>
                @empty
                    <td>
                        <td colspan="5" class="text-center">Aún no ha registrado elementos</td>
                    </td>
                @endforelse
            </tbody>
            </table>
        </div>
    </div>
</div>

<div class="text-center mt-3">
    {!! $almacenes->links() !!}
</div>

@endsection