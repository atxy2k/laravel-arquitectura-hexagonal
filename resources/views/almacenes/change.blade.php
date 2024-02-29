@extends('templates.layout')
@section('content')

    <div class="card mt-3">
        <div class="card-header">Editar almacen</div>
        <div class="card-body">
            <form action="{{ route('almacenes.store-change', $almacen->id) }}" method="post">
                @csrf
                <div class="row">
                    <label for="nombre" class="col-3 text-right mt-2">Nombre</label>
                    <div class="col-9">
                        <input type="text" required name="nombre" class="form-control" 
                            value="{{ old('nombre', $almacen->nombre) }}"
                            autofocus="true" placeholder="Nombre del almacen">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-9 offset-3">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                        <a href="{{ route('almacenes.index') }}" class="btn btn-secondary">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection