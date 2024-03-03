<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Producto extends Model
{
    use HasFactory;
    protected $table = 'productos';
    protected $fillable = [
        'nombre','slug','marca_id','descripcion','codigo_barras',
        'departamento_id', 'created_by_id','updated_by_id'
    ];
    protected $guarded = ['id'];

    public function marca() : BelongsTo{
        return $this->belongsTo(Marca::class,'marca_id');
    }

    public function departamento() : BelongsTo{
        return $this->belongsTo(Departamento::class,'departamento_id');
    }

    public function created_by(): BelongsTo{
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function updated_by(): BelongsTo{
        return $this->belongsTo(User::class, 'updated_by_id');
    }

}
