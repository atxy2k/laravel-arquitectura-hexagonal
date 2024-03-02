<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddRoleRequest;
use App\Throwables\General\NameIsNotAvailableException;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Prologue\Alerts\Facades\Alert;
use Spatie\Permission\Models\Permission;
use Throwable;
use Illuminate\Support\Facades\DB;

class RolesController extends Controller
{
    public function index(){
        $roles = Role::paginate(5);
        return view('roles.index', compact('roles'));
    }

    public function add(){
        $titles = ['almacen','departamento','marca','user','role'];
        $permissions = [];
        foreach($titles as $title){
            $list = Permission::where('name','like', "%$title%")->pluck('name')->all();
            $permissions[$title] = $list;
        }
        return view('roles.add', compact('permissions'));
    }

    public function store(AddRoleRequest $request){
        try
        {
            DB::beginTransaction();
            $exists = Role::where('name', $request->get('name'))->exists();
            throw_if($exists, NameIsNotAvailableException::class);
            $role = Role::create(['name' => $request->get('name')]);
            $role->syncPermissions($request->get('permissions'));
            DB::commit();
            Alert::success('Role creado correctamente')->flash();
            return redirect()->route('roles.index');
        }
        catch(Throwable $e)
        {
            DB::rollBack();
            Alert::error($e->getMessage())->flash();
            return redirect()->route('roles.index');
        }
    }

    public function change(int $id){
        // show view
    }

    public function store_change(int $id){
        // store
    }

    public function delete(int $id){
        $role = Role::find($id);
        if(is_null($role)){
            Alert::error('Ocurrió un error al localizar el rol')->flash();
            return redirect()->route('roles.index');
        }
        $role->delete();
        Alert::warning('Rol eliminado correctamente')->flash();
        return redirect()->route('roles.index');
    }

}
