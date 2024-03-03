<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Almacen;
use App\Services\MovimientosService;
use Illuminate\Http\Request;

class ExistenciasController extends Controller
{
    
    public function index(){
        $productos = Producto::all();
        $almacenes = Almacen::all();
        return view('existencias.index', compact('productos','almacenes'));
    }

    public function add(Request $request, MovimientosService $movimientosService){
        if($request->isMethod('post')){
            if(!$movimientosService->add($request->all())){
                return redirect()->route('existencias.add')->withInput($request->all());
            }
            return redirect()->route('existencias.index');
        }
        $productos = Producto::orderBy('nombre','asc')->get();
        $almacenes = Almacen::orderBy('nombre','asc')->get();
        return view('existencias.add', compact('productos','almacenes'));
    }

}
