@extends('templates.layout')
@section('content')

<div class="text-right">
    <a href="{{ route('marcas.add') }}" class="btn btn-primary">Agregar marca</a>
</div>

<div class="card mt-3">
    <div class="card-header">Marcas</div>
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
                @forelse ($marcas as $marca)
                    <tr>
                        <td>{{ $marca->id }}</td>
                        <td>{{ $marca->nombre }}</td>
                        <td>
                            <div>{{ $marca->created_by->name }}</div>
                            <div>{{ $marca->created_at->fromNow() }}</div>
                        </td>
                        <td>
                            <div>{{ $marca->updated_by->name }}</div>
                            <div>{{ $marca->updated_at->fromNow() }}</div>
                        </td>
                        <td>
                            <a href="{{ route('marcas.change', $marca->id) }}" class="btn btn-primary">Editar</a>
                            <a href="{{ route('marcas.delete', $marca->id) }}" class="btn btn-danger">Eliminar</a>
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

@endsection