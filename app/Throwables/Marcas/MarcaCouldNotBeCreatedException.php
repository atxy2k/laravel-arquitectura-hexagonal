<?php namespace App\Throwables;

use Exception;

class MarcaCouldNotBeCreatedException extends Exception{
    protected $message = 'Ocurrió un error al registrar la marca';
}