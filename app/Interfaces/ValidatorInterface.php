<?php namespace App\Interfaces;

use Illuminate\Contracts\Support\MessageBag;

interface ValidatorInterface
{
    /**
     * @param array $data
     * @return ValidatorInterface
     */
    public function with(array $data = []) : ValidatorInterface;

    /**
     * @param string|null $key
     * @return array
     */
    public function getRules(string $key = null ) : array;

    /**
     * @param string $key
     * @return bool
     */
    public function passes(string $key = 'create') : bool;

    /**
     * @param string $key
     * @return bool
     */
    public function fails(string $key = 'create') : bool;

    /**
     * @param string $parent
     * @param string|null $key
     * @param string|null $value
     * @return ValidatorInterface
     */
    public function add( string $parent = 'create', string $key = null, string $value = null ) : ValidatorInterface;

    /**
     * @param array $key
     * @return ValidatorInterface
     */
    public function ignore( array $key = []) : ValidatorInterface;

    /**
     * @return MessageBag
     */
    public function errors() : MessageBag;
}
