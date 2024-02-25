<?php namespace App\Repositories;

use App\Infrastructure\Repository;
use App\Models\Marca;

class MarcasRepository extends Repository {

    protected string|null $model = Marca::class;


    public function findBySlug(string $slug, int|null $id = null): ?Marca{
        return $id !== null ?
            $this->query->where('id','!=', $id)->where('slug', $slug)->first() :
            $this->query->where('slug', $slug)->first();
    }

}