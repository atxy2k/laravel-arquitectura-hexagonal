<?php namespace App\Http\Controllers;

use App\Http\Requests\AddAlmacenRequest;
use App\Http\Requests\ChangeAlmacenRequest;
use App\Models\Almacen;
use App\Throwables\General\NameIsNotAvailableException;
use Throwable;
use Exception;
use Illuminate\Support\Facades\DB;
use Prologue\Alerts\Facades\Alert;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class AlmacenesController extends Controller
{
    public function index(){
        $this->authorize('view any almacen');
        $almacenes = Almacen::paginate(5);
        return view('almacenes.index', compact('almacenes'));
    }

    public function add(){
        $this->authorize('add almacen');
        return view('almacenes.add');
    }

    public function store(AddAlmacenRequest $request){
        $this->authorize('add almacen');
        try
        {
            DB::beginTransaction();
            $duplicated = Almacen::where('slug', Str::slug($request->nombre))->exists();
            throw_if($duplicated, NameIsNotAvailableException::class);
            $data = Arr::only($request->all(), ['nombre']);
            $data['slug'] = Str::slug($request->get('nombre'));
            $data['created_by_id'] = Auth::id();
            $data['updated_by_id'] = Auth::id();
            $almacen = Almacen::create($data);
            throw_if(is_null($almacen), new Exception('Ocurrió un error al registrar el almacen'));
            DB::commit();
            Alert::success('Almacen registrado correctamente')->flash();
            return redirect()->route('almacenes.index');
        }
        catch(Throwable $e)
        {
            DB::rollBack();
            Alert::error($e->getMessage());
            return redirect()->route('almacenes.index');
        }
    }

    public function change(int $id){
        $this->authorize('change almacen');
        $almacen = Almacen::find($id);
        if(is_null($almacen)){
            Alert::error('Ocurrió un error al localizar el almacen seleccionado');
            return redirect()->route('almacenes.index');
        }
        return view('almacenes.change', compact('almacen'));
    }

    public function store_change(int $id, ChangeAlmacenRequest $request){
        $this->authorize('change almacen');
        try
        {
            DB::beginTransaction();
            $almacen = Almacen::findOrFail($id);
            $exists = Almacen::where('slug', Str::slug($request->get('nombre')))
                ->where('id','!=', $id)->exists();
            throw_if($exists, NameIsNotAvailableException::class);
            $almacen->update([
                'nombre' => $request->get('nombre'),
                'slug' => Str::slug($request->get('nombre')),
                'updated_by_id' => Auth::id()
            ]);
            DB::commit();
            Alert::success('Elemento actualizado correctamente')->flash();
            return redirect()->route('almacenes.index');
        }
        catch(Throwable $e)
        {
            DB::rollBack();
            Alert::error($e->getMessage())->flash();
            return redirect()->route('almacenes.change')->withInput($request->all());
        }
    }

    public function delete(int $id){
        $this->authorize('delete almacen');
        $almacen = Almacen::find($id);
        if(is_null($almacen)){
            Alert::error('Ocurrió un error al localizar el almacen seleccionado');
            return redirect()->route('almacenes.index');
        }
        $almacen->delete();
        Alert::warning('Elemento eliminado exitosamente')->flash();
        return redirect()->route('almacenes.index');
    }

}
