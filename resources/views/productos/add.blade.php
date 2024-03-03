@extends('templates.layout')
@section('content')

    <div class="card mt-3">
        <div class="card-header">Agregar producto</div>
        <div class="card-body">
            <form action="{{ route('productos.store') }}" method="post">
                @csrf
                <div class="row">
                    <label for="nombre" class="col-3 text-right mt-2">Nombre</label>
                    <div class="col-9">
                        <input type="text" required name="nombre" class="form-control" 
                            value="{{ old('nombre') }}"
                            autofocus="true" placeholder="Nombre del producto">
                    </div>
                </div>
                <div class="row mt-2">
                    <label for="descripcion" class="col-3 text-right mt-2">Descripción</label>
                    <div class="col-9">
                        <input type="text" required name="descripcion" class="form-control" 
                            value="{{ old('descripcion') }}"
                            placeholder="Descripción del producto">
                    </div>
                </div>
                <div class="row mt-2">
                    <label for="codigo_barras" class="col-3 text-right mt-2">Código de barras</label>
                    <div class="col-9">
                        <input type="text" required name="codigo_barras" class="form-control" maxlength="12"
                            value="{{ old('codigo_barras') }}"
                            placeholder="Código de barras del producto">
                    </div>
                </div>
                <div class="row mt-2">
                    <label for="marca_id" class="col-3 text-right mt-2">Marca</label>
                    <div class="col-9">
                        <select name="marca_id" id="marca_id" class="form-control">
                            <option value="" selected disabled>Seleccione una opción</option>
                            @foreach ($marcas as $marca)
                                <option value="{{$marca->id}}">{{ $marca->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row mt-2">
                    <label for="departamento_id" class="col-3 text-right mt-2">Departamento</label>
                    <div class="col-9">
                        <select name="departamento_id" id="departamento_id" class="form-control">
                            <option value="" selected disabled>Seleccione una opción</option>
                            @foreach ($departamentos as $departamento)
                                <option value="{{$departamento->id}}">{{ $departamento->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-9 offset-3">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                        <a href="{{ route('productos.index') }}" class="btn btn-secondary">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection