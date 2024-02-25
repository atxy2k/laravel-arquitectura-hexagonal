<?php namespace App\Throwables\Users;

use Exception;

class UserCouldNotBeCreatedException extends Exception {
    protected $message = 'Ocurrió un error al registrar el usuario';
}