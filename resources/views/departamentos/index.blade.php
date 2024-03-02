@extends('templates.layout')
@section('content')

<div class="text-right">
    <a href="{{ route('departamentos.add') }}" class="btn btn-primary">Agregar departamento</a>
</div>

<div class="card mt-3">
    <div class="card-header">Departamento</div>
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
                @forelse ($departamentos as $departamento)
                    <tr>
                        <td>{{ $departamento->id }}</td>
                        <td>{{ $departamento->nombre }}</td>
                        <td>
                            <div>{{ $departamento->created_by->name }}</div>
                            <div>{{ $departamento->created_at->fromNow() }}</div>
                        </td>
                        <td>
                            <div>{{ $departamento->updated_by->name }}</div>
                            <div>{{ $departamento->updated_at->fromNow() }}</div>
                        </td>
                        <td>
                            @can('change departamento')
                                <a href="{{ route('departamentos.change', $departamento->id) }}" class="btn btn-primary">Editar</a>
                            @endcan
                            @can('delete departamento')
                                <a href="{{ route('departamentos.delete', $departamento->id) }}" class="btn btn-danger">Eliminar</a>
                            @endcan
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