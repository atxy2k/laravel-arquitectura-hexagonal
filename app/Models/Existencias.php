<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Existencias extends Model
{
    use HasFactory;
    protected $table = 'existencias';
    protected $fillable = [
        'producto_id','cantidad',
        'created_by_id','updated_by_id'
    ];

    public function producto() : BelongsTo{
        return $this->belongsTo(Producto::class,'producto_id');
    }

    public function created_by(): BelongsTo{
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function updated_by(): BelongsTo{
        return $this->belongsTo(User::class, 'updated_by_id');
    }

}
