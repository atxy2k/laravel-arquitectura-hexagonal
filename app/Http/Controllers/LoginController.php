<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Services\UsersService;

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
        // lanzar el error
        return redirect()->route('auth.login');
    }

    public function logout(UsersService $usersService){
        $usersService->logout();
        return redirect()->route('auth.login');
    }

}
