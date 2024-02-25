<?php namespace App\Throwables\Roles;

use Exception;

class RoleNotFoundException extends Exception {
    protected $message = 'Ocurrió un error al localizar el rol selecccionado';
}