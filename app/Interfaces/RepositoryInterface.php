<?php namespace App\Interfaces;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface RepositoryInterface extends CriteriaInterface
{
    /**
     * @return int
     */
    public function count() : int;

    /**
     * @param array $data
     * @return Model|null
     */
    public function create(array $data) : ?Model;

    /**
     * @param $id
     * @param array $attributes
     * @return bool
     */
    public function update($id, array  $attributes = []) : bool;

    /**
     * @param array $columns
     * @return Collection
     */
    public function all(array $columns = ['*']) : Collection;

    /**
     * @param $id
     * @param array $columns
     * @return Model|null
     */
    public function find($id, array $columns = ['*']) : ?Model;

    /**
     * @param $id
     * @param array $columns
     * @return Model|null
     */
    public function findWithTrashed($id, array $columns = ['*']) : ?Model;

    /**
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function findOrFail($id, array $columns = ['*']) : Model;

    /**
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function findOrFailWithTrashed($id, array $columns = ['*']) : Model;

    /**
     * @param $ids
     * @return int
     */
    public function destroy($ids) : int;

    /**
     * @param $id
     * @return bool
     */
    public function delete($id) : bool ;

    /**
     * @return Model|Builder
     */
    public function model() : Model|Builder;

    /**
     * @param string $column
     * @return int
     */
    public function max(string $column) : int;

    /**
     * @param string $column
     * @return int
     */
    public function min(string $column) : int;

    /**
     * @param string $col
     * @param string|null $key
     * @return array
     */
    public function lists(string $col, string $key = null) : array ;

    /**
     * @param string $col
     * @param string|null $key
     * @return array
     */
    public function pluck(string $col, string $key = null) : array ;

    /**
     * @param int $per_page
     * @param int $page
     * @return LengthAwarePaginator
     */
    public function paginate(int $per_page, int $page = 1) : LengthAwarePaginator;

    /**
     * @return Model|null
     */
    public function first() : ?Model;

    /**
     * @return Model|null
     */
    public function last() : ?Model;
}
