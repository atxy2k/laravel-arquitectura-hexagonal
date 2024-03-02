<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AddMarcaRequest;
use App\Http\Requests\ChangeMarcaRequest;
use App\Repositories\MarcasRepository;
use App\Services\MarcasService;
use Prologue\Alerts\Facades\Alert;

class MarcasController extends Controller
{
    public function index(MarcasRepository $marcasRepository){
        $this->authorize('view any marca');
        $marcas = $marcasRepository->all();
        return view('marcas.index', compact('marcas'));
    }

    public function add(){
        $this->authorize('add marca');
        return view('marcas.add');
    }

    public function store(AddMarcaRequest $request, MarcasService $marcasService){
        $this->authorize('add marca');
        if($marcasService->create($request->all())){
            Alert::success('Marca registradad correctamente')->flash();
            return redirect()->route('marcas.index');
        }
        Alert::error($marcasService->errors()->first())->flash();
        return redirect()->route('marcas.add')->withInput($request->all());
    }

    public function change(int $id, MarcasRepository $marcasRepository){
        $this->authorize('change marca');
        $marca = $marcasRepository->find($id);
        if(is_null($marca))
        {
            Alert::error('Ocurrió un error al localizar la marca seleccionada')->flash();
            return redirect()->route('marcas.index');
        }
        return view('marcas.change', compact('marca'));
    }

    public function store_change(int $id, ChangeMarcaRequest $request, MarcasService $marcasService){
        $this->authorize('change marca');
        if(!$marcasService->change($id, $request->all())){
            Alert::error($marcasService->errors()->first())->flash();
            return redirect()->route('marcas.change', $id);
        }
        Alert::success('Marca actualizada')->flash();
        return redirect()->route('marcas.index');
    }

    public function delete(int $id, MarcasService $marcasService){
        $this->authorize('delete marca');
        if(!$marcasService->delete($id)){
            Alert::error($marcasService->errors()->first())->flash();
        }
        Alert::warning('Marca eliminada correctamente')->flash();
        return redirect()->route('marcas.index');
    }

}
