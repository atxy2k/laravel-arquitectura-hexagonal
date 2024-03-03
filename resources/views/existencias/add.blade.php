@extends('templates.layout')
@section('content')

    <div class="card mt-3">
        <div class="card-header">Registrar movimiento de inventario</div>
        <div class="card-body">
            <form action="{{ route('existencias.add') }}" method="post">
                @csrf
                <div class="row">
                    <label for="producto_id" class="col-3 text-right mt-2">Producto</label>
                    <div class="col-9">
                        <select name="producto_id" id="producto_id" class="form-control">
                            <option value="" selected disabled>Seleccione un producto</option>
                            @foreach ($productos as $producto)
                                <option value="{{ $producto->id }}">{{ $producto->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row mt-2">
                    <label for="almacen_id" class="col-3 text-right mt-2">Almacen</label>
                    <div class="col-9">
                        <select name="almacen_id" id="almacen_id" class="form-control">
                            <option value="" selected disabled>Seleccione un almacen</option>
                            @foreach ($almacenes as $almacen)
                                <option value="{{ $almacen->id }}">{{ $almacen->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row mt-2">
                    <label for="tipo_movimiento" class="col-3 text-right mt-2">Tipo de movimiento</label>
                    <div class="col-9">
                        <select name="tipo_movimiento" id="tipo_movimiento" class="form-control">
                            <option value="{{ App\Models\Movimiento::ENTRADA }}">Entrada</option>
                            <option value="{{ App\Models\Movimiento::SALIDA }}">Salida</option>
                        </select>
                    </div>
                </div>
                <div class="row mt-2">
                    <label for="number" class="col-3 text-right mt-2">Cantidad</label>
                    <div class="col-9">
                        <input type="number" required name="cantidad" step="1" min="1" max="100000" class="form-control" 
                            value="{{ old('cantidad') }}"
                            autofocus="true" placeholder="Cantidad a mover">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-9 offset-3">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                        <a href="{{ route('existencias.index') }}" class="btn btn-secondary">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection