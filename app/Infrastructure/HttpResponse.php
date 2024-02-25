<?php namespace App\Infrastructure;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;

class HttpResponse implements Arrayable, Jsonable
{

    protected $status = Response::HTTP_OK;
    protected $errors = [];
    protected $data   = null;

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'status'    => $this->status,
            'errors'    => $this->errors,
            'first_error' => count($this->errors) > 0 ? Arr::first($this->errors) : null,
            'data'      => $this->data
        ];
    }

    public function addError(string $error) : HttpResponse
    {
        $this->errors[] = $error;
        return $this;
    }

    public function pushError(string $error) : HttpResponse
    {
        return $this->addError($error);
    }

    public function addErrors( array $errors = [] ) : HttpResponse
    {
        $this->errors = array_merge($this->errors, $errors);
        return $this;
    }

    public function pushErrors( array $errors = [] ) : HttpResponse
    {
        return $this->addErrors($errors);
    }

    public function withStatus( int $status ) : HttpResponse
    {
        $this->status = $status;
        return $this;
    }

    public function withData( $data ) : HttpResponse
    {
        $this->data = $data;
        return $this;
    }

    public function getData()
    {
        return $this->data;
    }

    public static function create()
    {
        return new HttpResponse();
    }

    /**
     * Convert the object to its JSON representation.
     *
     * @param  int $options
     * @return string
     */
    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }


}
