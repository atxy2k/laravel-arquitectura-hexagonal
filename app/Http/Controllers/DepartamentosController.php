<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Departamento;
use App\Http\Requests\AddDepartamentoRequest;
use App\Http\Requests\ChangeDepartamentoRequest;
use App\Throwables\Departamentos\DepartamentoCouldNotBeCreatedException;
use App\Throwables\Departamentos\DepartamentoNotFoundException;
use App\Throwables\General\NameIsNotAvailableException;
use Throwable;
use Exception;
use Illuminate\Support\Facades\DB;
use Prologue\Alerts\Facades\Alert;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class DepartamentosController extends Controller
{
    
    public function index(){
        $this->authorize('view any departamento');
        $departamentos = Departamento::all();
        return view('departamentos.index', compact('departamentos'));
    }

    public function add(){
        $this->authorize('add departamento');
        return view('departamentos.add');
    }

    public function store(AddDepartamentoRequest $request){
        $this->authorize('add departamento');
        try
        {
            DB::beginTransaction();
            $duplicated = Departamento::where('slug', Str::slug($request->get('nombre')) )->exists();
            throw_if($duplicated, NameIsNotAvailableException::class);
            $data = Arr::only($request->all(), ['nombre']);
            $data['slug'] = Str::slug($request->get('nombre'));
            $data['created_by_id'] = Auth::id();
            $data['updated_by_id'] = Auth::id();
            $departamento = Departamento::create($data);
            throw_if(is_null($departamento), DepartamentoCouldNotBeCreatedException::class);
            DB::commit();
            Alert::success('Departamento registrado correctamente')->flash();
            return redirect()->route('departamentos.index');
        }
        catch(Throwable $e)
        {
            DB::rollBack();
            Alert::error($e->getMessage())->flash();
            return redirect()->route('departamentos.add')->withInput($request->all());
        }
    }

    public function change(int $id){
        $this->authorize('change departamento');
        $departamento = Departamento::find($id);
        if(is_null($departamento)){
            Alert::error('Ocurrió un error al localizar el departamento seleccionado');
            return redirect()->route('departamentos.index');
        }
        return view('departamentos.change', compact('departamento'));
    }

    public function store_change(int $id, ChangeDepartamentoRequest $request){
        $this->authorize('change departamento');
        try
        {
            $departamento = Departamento::find($id);
            throw_if(is_null($departamento), DepartamentoNotFoundException::class);
            DB::beginTransaction();
            $exists = Departamento::where('slug', Str::slug($request->get('nombre')))
                ->where('id', '!=', $departamento->id)->exists();
            throw_if($exists, NameIsNotAvailableException::class);
            $departamento->update([
                'nombre' => $request->get('nombre'),
                'slug' => Str::slug($request->get('nombre')),
                'updated_by_id' => Auth::id()
            ]);
            DB::commit();
            Alert::success('Elemento actualizado correctamente')->flash();
            return redirect()->route('departamentos.index');
        }
        catch(Throwable $e)
        {
            DB::rollBack();
            Alert::error($e->getMessage())->flash();
            return redirect()->route('departamentos.change', $id)->withInput($request->all());
        }
    }

    public function delete(int $id){
        $this->authorize('delete departamento');
        $departamento = Departamento::find($id);
        if(is_null($departamento)){
            Alert::error('Ocurrió un error al localizar el departamento seleccionado');
            return redirect()->route('departamentos.index');
        }
        $departamento->delete();
        Alert::warning('Elemento eliminado exitosamente')->flash();
        return redirect()->route('departamentos.index');
    }

}
