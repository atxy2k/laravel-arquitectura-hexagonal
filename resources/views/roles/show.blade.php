@extends('templates.layout')
@section('content')

    <div class="card mt-3">
        <div class="card-header">Visualizar rol</div>
        <div class="card-body">
            <div class="row">
                <label for="name" class="col-3 text-right mt-2">Nombre</label>
                <div class="col-9">
                    <input type="text" required name="name" class="form-control" readonly disabled
                        value="{{ old('name', $role->name) }}"
                        autofocus="true" placeholder="Nombre del rol">
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-9 offset-3">
                    <h3>Permisos</h3>
                </div>
                <div class="col-9 offset-3">
                    <div class="table-responsive">
                        <table class="table table-stripe">
                            <thead>
                                <tr>
                                    <th style="width: 10px;">Modulo</th>
                                    <th>Permisos</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($permissions as $title => $permisos)
                                    <tr>
                                        <td><strong>{{ ucfirst($title) }}</strong></td>
                                        <td>
                                            @foreach ($permisos as $key => $permiso)
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" disabled
                                                        {{ $role->hasPermissionTo($permiso) ? 'checked' : '' }}
                                                        id="check_{{$title}}_{{$key}}" name="permissions[]" value="{{ $permiso }}">
                                                    <label class="form-check-label" for="check_{{$title}}_{{$key}}">{{ $permiso }}</label>
                                                </div>
                                            @endforeach
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="row mt-2">
                <div class="col-9 offset-3">
                    <a href="{{ route('roles.index') }}" class="btn btn-secondary">Volver</a>
                </div>
            </div>
        </div>
    </div>

@endsection