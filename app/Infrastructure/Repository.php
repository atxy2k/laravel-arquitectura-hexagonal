<?php namespace App\Infrastructure;

use App\Interfaces\RepositoryInterface;
use BadMethodCallException;
use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;
use Throwable;

class Repository implements RepositoryInterface
{

    protected string|null $model = null;
    protected Model|null|Builder $query = null;
    protected Container|null $app = null;
    protected array $criteria = [];

    public function __construct(Container $app)
    {
        $this->query = $app->make($this->model);
        $this->app = $app;
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return $this->query->count();
    }

    /**
     * @param array $data
     * @return Model|null
     */
    public function create(array $data): ?Model
    {
        return $this->query->create($data);
    }

    /**
     * @param $id
     * @param array $attributes
     * @return bool
     */
    public function update($id, array $attributes = []): bool
    {
        return $this->query->findOrFail($id)->update($attributes);
    }

    /**
     * @param array $columns
     * @return Collection
     */
    public function all(array $columns = ['*']): Collection
    {
        return $this->query->get($columns);
    }

    /**
     * @param $id
     * @param array $columns
     * @return Model|null
     */
    public function find($id, array $columns = ['*']): ?Model
    {
        return $this->query->find($id,$columns);
    }

    /**
     * @param $id
     * @param array $columns
     * @return Model|null
     */
    public function findWithTrashed($id, array $columns = ['*']): ?Model
    {
        return $this->query->withTrashed()->find($id,$columns);
    }

    /**
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function findOrFail($id, array $columns = ['*']) : Model
    {
        return $this->query->findOrFail($id,$columns);
    }

    /**
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function findOrFailWithTrashed($id, array $columns = ['*']) : Model
    {
        return $this->query->withTrashed()->findOrFail($id,$columns);
    }

    /**
     * @param $ids
     * @return int
     */
    public function destroy($ids): int
    {
        return $this->query->destroy($ids);
    }

    /**
     * @param $id
     * @return bool
     */
    public function delete($id): bool
    {
        return $this->query->findOrFail($id)->delete();
    }

    /**
     * @return Model|Builder
     */
    public function model(): Model|Builder
    {
        return $this->query;
    }

    /**
     * @param string $column
     * @return int
     */
    public function max(string $column): int
    {
        return $this->query->max($column);
    }

    /**
     * @param string $column
     * @return int
     */
    public function min(string $column): int
    {
        return $this->query->min($column);
    }

    /**
     * @param string $col
     * @param string|null $key
     * @return array
     */
    public function lists(string $col, string $key = null): array
    {
        return $this->query->pluck($col,$key)->all();
    }

    /**
     * @param string $col
     * @param string|null $key
     * @return array
     */
    public function pluck(string $col, string $key = null): array
    {
        return $this->lists($col, $key);
    }

    /**
     * @param int $per_page
     * @param int $page
     * @return LengthAwarePaginator
     */
    public function paginate(int $per_page, int $page = 1): LengthAwarePaginator
    {
        return $this->query->paginate( $per_page, ['*'], 'page', $page );
    }

    /**
     * @return Model|null
     */
    public function first(): ?Model
    {
        return $this->query->first();
    }

    /**
     * @return Model|null
     */
    public function last(): ?Model
    {
        return $this->query->last();
    }

    /**
     * Add a Criteria object to criteria to going to apply later.
     * @param Criteria $criteria
     * @return RepositoryInterface
     */
    public function pushCriteria(Criteria $criteria): RepositoryInterface
    {
        if(!in_array($criteria, $this->criteria))
            $this->criteria[] = $criteria;
        return $this;
    }

    /**
     * Add a Criteria object to criteria to going to apply later.
     * @param Criteria $criteria
     * @return RepositoryInterface
     */
    public function addCriteria(Criteria $criteria): RepositoryInterface
    {
        return $this->pushCriteria($criteria);
    }

    /**
     * @param $name
     * @param $arguments
     * @return mixed
     * @throws Throwable
     */
    public function __call($name, $arguments)
    {
        if(Str::endsWith($name, 'WithCriteria'))
        {
            $functionToCall = str_replace('WithCriteria', '', $name);
            throw_unless(method_exists($this,$functionToCall), BadMethodCallException::class);
            $otherModel = $this->app->make($this->model);
            /** @var Criteria $criteria */
            foreach ( $this->getCriteria() as $criteria )
            {
                $this->query = $criteria->apply($this->query, $this);
            }
            $response = call_user_func_array([$this,$functionToCall], $arguments);
            $this->query = $otherModel;
            return $response;
        }
        throw new BadMethodCallException;
    }

    /**
     * Return all criteria added
     * @return array
     */
    public function getCriteria(): array
    {
        return $this->criteria;
    }

    public function cleanCriteria(): Repository
    {
        $this->criteria = [];
        return $this;
    }

}
