<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Movimiento extends Model
{
    public const ENTRADA = 1;
    public const SALIDA = 2;
    use HasFactory;
    protected $table = 'movimientos';
    protected $fillable = [
        'producto_id','almacen_id','tipo_movimiento',
        'cantidad_anterior','cantidad','cantidad_posterior',
        'created_by_id'
    ];
    
    public function producto() : BelongsTo{
        return $this->belongsTo(Producto::class,'producto_id');
    }

    public function almacen() : BelongsTo{
        return $this->belongsTo(Almacen::class, 'almacen_id');
    }

    public function created_by(): BelongsTo{
        return $this->belongsTo(User::class, 'created_by_id');
    }

}
