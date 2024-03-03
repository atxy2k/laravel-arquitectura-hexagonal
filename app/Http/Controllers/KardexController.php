<?php

namespace App\Http\Controllers;

use App\Models\Movimiento;
use Illuminate\Http\Request;

class KardexController extends Controller
{
    public function index(){
        $movimientos = Movimiento::orderBy('created_at','desc')->paginate(10);
        return view('kardex.index', compact('movimientos'));
    }
}
