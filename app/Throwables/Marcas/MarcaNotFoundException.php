<?php namespace App\Throwables;

use Exception;

class MarcaNotFoundException extends Exception{
    protected $message = 'Ocurrió un error al localizar la marca seleccionada';
}