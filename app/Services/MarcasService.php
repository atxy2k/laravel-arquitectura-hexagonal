<?php namespace App\Services;

use App\Infrastructure\BaseService;
use App\Models\Marca;
use App\Repositories\MarcasRepository;
use App\Throwables\General\NameIsNotAvailableException;
use App\Throwables\MarcaCouldNotBeCreatedException;
use App\Throwables\MarcaNotFoundException;
use App\Validators\MarcasValidator;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Throwable;
use Exception;

class MarcasService extends BaseService {

    public function __construct(MarcasValidator $marcasValidator, private MarcasRepository $marcasRepository){
        parent::__construct();
        $this->validator = $marcasValidator;
    }

    public function create(array $data) : ?Marca{
        $return = null;
        try
        {
            DB::beginTransaction();
            throw_unless($this->validator->with($data)->passes(MarcasValidator::CREATE), 
                new Exception($this->validator->errors()->first()));
            $marca_data = Arr::only($data,['nombre']);
            $marca_data['slug'] = Str::slug($marca_data['nombre']);
            $marca_data['created_by_id'] = Auth::id();
            $marca_data['updated_by_id'] = Auth::id();
            $marca = $this->marcasRepository->create($marca_data);
            throw_if(is_null($marca), MarcaCouldNotBeCreatedException::class);
            DB::commit();
            $return = $marca;
        }
        catch(Throwable $e)
        {
            DB::rollBack();
            $this->pushError($e->getMessage());
        }
        return $return;
    }

    public function change(int $id, array $data) : bool{
        $return = false;
        try
        {
            DB::beginTransaction();
            $item = $this->marcasRepository->find($id);
            throw_if(is_null($item), MarcaNotFoundException::class);
            $slug = Str::slug($data['nombre']);
            $existent = $this->marcasRepository->findBySlug($slug, $id);
            throw_if(!is_null($existent), NameIsNotAvailableException::class);
            $item->update([
                'nombre' => Arr::get($data,'nombre'),
                'slug' => Str::slug(Arr::get($data,'nombre')),
                'updated_by_id' => Auth::id()
            ]);
            DB::commit();
            $return = true;
        }
        catch(Throwable $e)
        {
            DB::rollBack();
            $this->pushError($e->getMessage());
        }
        return $return;
    }

    public function delete(int $id) : bool{
        $return = false;
        try
        {
            $item = $this->marcasRepository->find($id);
            throw_if(is_null($item), MarcaNotFoundException::class);
            $item->delete();
            $return = true;
        }
        catch(Throwable $e)
        {
            $this->pushError($e->getMessage());
        }
        return $return;
    }

}