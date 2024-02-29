<?php namespace App\Throwables\Departamentos;

use Exception;

class DepartamentoNotFoundException extends Exception{
    protected $message = 'Ocurrió un error al localizar el departamento seleccionado';
}