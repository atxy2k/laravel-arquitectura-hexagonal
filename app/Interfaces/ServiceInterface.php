<?php

namespace App\Interfaces;

use Illuminate\Support\MessageBag;

interface ServiceInterface
{
    public function errors() : MessageBag;

    public function rules(string $key = null) : array;

    public function pushErrors(MessageBag $errors) : ServiceInterface;

    public function pushError(string $message, string $key = 'error') : ServiceInterface;

    public function clearErrors() : ServiceInterface;

    public function countErrors() : int;
}
