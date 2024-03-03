<?php namespace App\Services;

use App\Models\Movimiento;
use Throwable;
use Exception;
use Prologue\Alerts\Facades\Alert;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use App\Models\Existencias;
use App\Models\ExistenciasPorAlmacenModel;
use Illuminate\Support\Facades\Auth;

class MovimientosService {

    public function add(array $data) : ?Movimiento{
        $return = null;
        try
        {
            DB::beginTransaction();
            $validator = Validator::make($data, [
                'producto_id' => 'required|exists:productos,id',
                'almacen_id' => 'required|exists:almacenes,id',
                'tipo_movimiento' => 'required',
                'cantidad' => 'required'
            ]);
            throw_unless($validator->passes(), new Exception($validator->errors()->first()));
            $producto_id = (int) Arr::get($data,'producto_id');
            $almacen_id = (int) Arr::get($data,'almacen_id');
            $tipo_movimiento = (int) Arr::get($data,'tipo_movimiento');
            $cantidad = (int) Arr::get($data,'cantidad');

            $existencias = Existencias::where('producto_id', $producto_id)->first();
            if(is_null($existencias)){
                $existencias = Existencias::create([
                    'producto_id' => $producto_id,
                    'cantidad' => 0,
                    'created_by_id' => Auth::id(),
                    'updated_by_id' => Auth::id()
                ]);
            }

            $cantidad_anterior = $existencias->cantidad;
            $cantidad_resultante = null;
            if($tipo_movimiento === Movimiento::ENTRADA){
                $cantidad_resultante = $cantidad_anterior + $cantidad;
            }
            else
            {
                throw_if($cantidad > $cantidad_anterior, new Exception('No contamos con las existencias suficientes para el movimiento'));
                $cantidad_resultante = $cantidad_anterior - $cantidad;
            }
            throw_if(is_null($cantidad_resultante), new Exception('Ocurrió un error al calcular la cantidad resultante'));
            $existencias->update([
                'cantidad' => $cantidad_resultante,
                'updated_by_id' => Auth::id()
            ]);

            $existencias_almacen = ExistenciasPorAlmacenModel::where('producto_id', $producto_id)
                ->where('almacen_id', $almacen_id)->first();
            if(is_null($existencias_almacen)){
                $existencias_almacen = ExistenciasPorAlmacenModel::create([
                    'producto_id' => $producto_id,
                    'almacen_id' => $almacen_id,
                    'cantidad' => 0,
                    'created_by_id' => Auth::id(),
                    'updated_by_id' => Auth::id()
                ]);
            }
            $cantidad_anterior_almacen = $existencias_almacen->cantidad;
            if($tipo_movimiento === Movimiento::ENTRADA){
                $cantidad_resultante_almacen = $cantidad_anterior_almacen + $cantidad;
            }
            else
            {
                throw_if($cantidad > $cantidad_anterior_almacen, new Exception('El almacen no cuenta con stock suficiente'));
                $cantidad_resultante_almacen = $cantidad_anterior_almacen - $cantidad;
            }

            $existencias_almacen->update([
                'cantidad' => $cantidad_resultante_almacen,
                'updated_by_id' => Auth::id()
            ]);

            $movimiento = Movimiento::create([
                'producto_id' => $producto_id,
                'almacen_id' => $almacen_id,
                'tipo_movimiento' => $tipo_movimiento,
                'cantidad_anterior' => $cantidad_anterior,
                'cantidad' => $cantidad,
                'cantidad_posterior' => $cantidad_resultante,
                'created_by_id' => Auth::id()
            ]);
            throw_if(is_null($movimiento), new Exception('Ocurrió un error al registrar el movimiento'));
            Alert::success('Movimiento registrado correctamente')->flash();
            DB::commit();
            $return = $movimiento;
        }
        catch(Throwable $e)
        {
            DB::rollBack();
            Alert::error($e->getMessage())->flash();
        }
        return $return;
    }

}