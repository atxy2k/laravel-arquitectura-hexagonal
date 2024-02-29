<?php namespace App\Throwables\Departamentos;

use Exception;

class DepartamentoCouldNotBeCreatedException extends Exception {
    protected $messsage = 'Ocurrió un error al registrar el departamento';
}