@extends('templates.layout')
@section('content')

<div class="text-right">
    <a href="{{ route('users.add') }}" class="btn btn-primary">Agregar usuario</a>
</div>

<div class="card mt-3">
    <div class="card-header">Usuarios</div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Rol de usuario</th>
                        <th>Fecha de registro</th>
                        <th>Fecha de última actualización</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->roles()->first()->name }}</td>
                        <td>{{ $user->created_at->fromNow() }}</td>
                        <td>{{ $user->updated_at->fromNow() }}</td>
                        <td>
                            <a href="#" class="btn btn-secondary">Ver</a>
                            @can('change', $user)
                                <a href="{{ route('users.change', $user->id) }}" class="btn btn-primary">Editar</a>
                            @endcan
                            @if (Auth::user()->can('delete', $user))
                                <a href="{{ route('users.delete', $user->id) }}" class="btn btn-danger">Eliminar</a>
                            @endif
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

<div class="text-center mt-3">
    {!! $users->links() !!}
</div>

@endsection