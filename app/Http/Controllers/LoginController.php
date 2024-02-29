<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Services\UsersService;
use Prologue\Alerts\Facades\Alert;

class LoginController extends Controller
{
    public function index(){
        return view('login.index');
    }

    public function login(LoginRequest $loginRequest, UsersService $usersService){
        if($usersService->login($loginRequest->all())){
            $loginRequest->session()->regenerate();
            return redirect()->route('dashboard.index');
        }
        Alert::error($usersService->errors()->first())->flash();
        return redirect()->route('auth.login');
    }

    public function logout(UsersService $usersService){
        $usersService->logout();
        return redirect()->route('auth.login');
    }

}
