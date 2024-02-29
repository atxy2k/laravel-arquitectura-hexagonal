<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Departamento extends Model
{
    use HasFactory;
    protected $table = 'departamentos';
    protected $fillable = [
        'nombre','slug',
        'created_by_id',
        'updated_by_id',
    ];
    protected $guarded = ['id'];

    public function created_by(): BelongsTo{
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function updated_by(): BelongsTo{
        return $this->belongsTo(User::class, 'updated_by_id');
    }

}
