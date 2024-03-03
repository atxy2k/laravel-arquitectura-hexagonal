<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddProductRequest;
use App\Models\Departamento;
use App\Models\Marca;
use Illuminate\Http\Request;
use App\Models\Producto;
use Throwable;
use Exception;
use Illuminate\Support\Arr;
use Prologue\Alerts\Facades\Alert;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProductosController extends Controller
{
    
    public function index(){
        $productos = Producto::paginate(5);
        return view('productos.index', compact('productos'));
    }

    public function add(){
        $marcas = Marca::all();
        $departamentos = Departamento::all();
        return view('productos.add', compact('marcas','departamentos'));
    }

    public function store(AddProductRequest $request){
        try
        {
            DB::beginTransaction();
            $data = Arr::only($request->all(), ['nombre','descripcion','codigo_barras','marca_id','departamento_id']);
            $data['slug'] = Str::slug($data['nombre']);
            $data['created_by_id'] = Auth::id();
            $data['updated_by_id'] = Auth::id();
            $producto = Producto::create($data);
            throw_if(is_null($producto), new Exception('Ocurrió un error al registrar el producto'));
            DB::commit();
            Alert::success('Producto registrado correctamente')->flash();
            return redirect()->route('productos.index');
        }
        catch(Throwable $e)
        {
            DB::rollBack();
            Alert::error($e->getMessage())->flash();
            return redirect()->route('productos.add')->withInput($request->all());
        }
    }

    public function change(int $id){
        try
        {
            $producto = Producto::findOrFail($id);
            $marcas = Marca::all();
            $departamentos = Departamento::all();
            return view('productos.change', compact('producto','marcas','departamentos'));
        }
        catch(Throwable $e)
        {
            Alert::error($e->getMessage())->flash();
            return redirect()->route('productos.index');
        }
    }

    public function store_change(int $id){

    }

    public function delete(int $id){

    }

}
