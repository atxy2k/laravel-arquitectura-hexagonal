<?php namespace App\Http\Controllers;

use App\Models\Almacen;
use App\Models\Movimiento;
use App\Models\Producto;
use App\Models\Existencias;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $total_productos = Producto::count();
        $movimientos = Movimiento::count();
        $almacenes = Almacen::count();
        $existencias_totales = Existencias::sum('cantidad');
        return view('dashboard.index', compact('total_productos','movimientos','existencias_totales','almacenes'));
    }
}
