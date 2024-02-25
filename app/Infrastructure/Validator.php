<?php

namespace App\Infrastructure;

use App\Interfaces\ValidatorInterface;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Validator as LaravelValidator;

class Validator implements ValidatorInterface
{
    protected array $rules = [
        'create' => [],
        'update' => []
    ];
    protected array $ignore = [];
    protected MessageBag|null $errors = null;
    protected array $data = [];

    public function __construct()
    {
        $this->errors = new MessageBag();
    }

    /**
     * @param array $data
     * @return ValidatorInterface
     */
    public function with(array $data = []): ValidatorInterface
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @param string|null $key
     * @return array
     */
    public function getRules(string $key = null): array
    {
        if ( $key !== null && strlen($key) > 0 && isset($this->rules[$key]) ) return $this->rules[$key];
        return $this->rules;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function passes(string $key = 'create'): bool
    {
        $aux = $this->rules[$key];
        foreach ( $this->ignore as $ignore )
        {
            unset($aux[$ignore]);
        }
        $validator = LaravelValidator::make($this->data, $aux);
        $return = $validator->passes();
        $this->errors = $validator->errors();
        return $return;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function fails(string $key = 'create'): bool
    {
        $aux = $this->rules[$key];
        foreach ( $this->ignore as $ignore )
        {
            unset($aux[$ignore]);
        }
        $validator = LaravelValidator::make($this->data, $aux);
        $return = $validator->fails();
        $this->errors = $validator->errors();
        return $return;
    }

    /**
     * @param string $parent
     * @param string|null $key
     * @param string|null $value
     * @return ValidatorInterface
     */
    public function add(string $parent = 'create', string $key = null, string $value = null): ValidatorInterface
    {
        if ( isset($this->rules[$parent]) && $key !== null && $value !== null && strlen($key) > 0)
        {
            $this->rules[$parent] +=  [ $key => $value ];
        }
        return $this;
    }

    /**
     * @param array $key
     * @return ValidatorInterface
     */
    public function ignore(array $key = []): ValidatorInterface
    {
        $this->ignore = $key;
        return $this;
    }

    /**
     * @return MessageBag
     */
    public function errors(): MessageBag
    {
        return $this->errors;
    }
}
