<?php namespace App\Throwables\General;

use Exception;

class NameIsNotAvailableException extends Exception {
    protected $message = 'El nombre no está disponible';
}