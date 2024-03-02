<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UsersService;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Prologue\Alerts\Facades\Alert;

class UsersController extends Controller
{
    public function index(){
        $this->authorize('view any user');
        $users = User::paginate(5);
        return view('users.index', compact('users'));
    }

    public function add(){
        $this->authorize('add user');
        $roles = Role::all();
        return view('users.add', compact('roles'));
    }

    public function store(Request $request, UsersService $usersService){
        $this->authorize('add user');
        if(is_null($usersService->create($request->all()))){
            Alert::error($usersService->errors()->first())->flash();
            return redirect()->route('users.add')->withInput($request->all());
        }
        Alert::success('Usuario registrado correctamente')->flash();
        return redirect()->route('users.index');
    }

    public function change(int $id){
        $this->authorize('change user');
    }

    public function store_change(int $id){
        $this->authorize('change user');
    }

    public function delete(int $id){
        $this->authorize('delete user');
    }

}
