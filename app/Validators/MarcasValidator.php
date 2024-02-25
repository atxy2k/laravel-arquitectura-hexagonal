<?php namespace App\Validators;

use App\Infrastructure\Validator;

class MarcasValidator extends Validator {

    public const CREATE = 'create';
    public const CHANGE = 'change';

    public array $rules = [
        self::CREATE => [
            'nombre' => 'required'
        ],
        self::CHANGE  => [
            'nombre' => 'required'
        ]
    ];

}