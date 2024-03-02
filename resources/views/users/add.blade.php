@extends('templates.layout')
@section('content')

    <div class="card mt-3">
        <div class="card-header">Agregar usuario</div>
        <div class="card-body">
            <form action="{{ route('users.store') }}" method="post">
                @csrf
                <div class="row">
                    <label for="name" class="col-3 text-right mt-2">Nombre</label>
                    <div class="col-9">
                        <input type="text" required name="name" class="form-control" 
                            value="{{ old('name') }}" id="name"
                            autofocus="true" placeholder="Nombre del usuario">
                    </div>
                </div>
                <div class="row mt-2">
                    <label for="email" class="col-3 text-right mt-2">Correo electrónico</label>
                    <div class="col-9">
                        <input type="email" required name="email" class="form-control" 
                            value="{{ old('email') }}" id="email"
                            placeholder="Correo electrónico">
                    </div>
                </div>
                <div class="row mt-2">
                    <label for="password" class="col-3 text-right mt-2">Contraseña</label>
                    <div class="col-9">
                        <input type="password" required name="password" class="form-control" 
                            value="{{ old('password') }}" id="passsword"
                            autofocus="true" placeholder="Contraseña del usuario">
                    </div>
                </div>
                <div class="row mt-2">
                    <label for="password_confirmation" class="col-3 text-right mt-2">Confirmar contraseña</label>
                    <div class="col-9">
                        <input type="password" required name="password_confirmation" class="form-control" 
                            value="{{ old('password_confirmation') }}" id="password_confirmation"
                            autofocus="true" placeholder="Confirmar contraseña">
                    </div>
                </div>
                <div class="row mt-2">
                    <label for="role_id" class="col-3 text-right mt-2">Rol del usuario</label>
                    <div class="col-9">
                        <select name="role_id" id="role_id" class="form-control" required>
                            <option value="">Seleccione una opción</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-9 offset-3">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                        <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection