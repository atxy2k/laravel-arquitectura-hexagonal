@extends('templates.layout')
@section('content')

<div class="text-right">
    <a href="{{ route('roles.add') }}" class="btn btn-primary">Agregar rol</a>
</div>

<div class="card mt-3">
    <div class="card-header">Roles</div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Permisos</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                @forelse ($roles as $role)
                    <tr>
                        <td>{{ $role->id }}</td>
                        <td>{{ $role->name }}</td>
                        <td>
                            {{ implode(', ', $role->permissions()->pluck('name')->all()) }}
                        </td>
                        <td>
                            <a href="{{ route('roles.change', $role->id) }}" class="btn btn-primary">Editar</a>
                            <a href="{{ route('roles.delete', $role->id) }}" class="btn btn-danger">Eliminar</a>
                        </td>
                    </tr>
                @empty
                    <td>
                        <td colspan="4" class="text-center">Aún no ha registrado elementos</td>
                    </td>
                @endforelse
            </tbody>
            </table>
        </div>
    </div>
</div>

<div class="text-center mt-3">
    {!! $roles->links() !!}
</div>

@endsection