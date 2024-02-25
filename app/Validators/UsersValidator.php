<?php namespace App\Validators;

use App\Infrastructure\Validator;

class UsersValidator extends Validator{

    public const CREATE = 'create';
    public const LOGIN = 'login';

    protected array $rules = [
        self::CREATE => [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed',
            'role_id' => 'required|exists:roles,id'
        ],
        self::LOGIN => [
            'email' => 'required|email',
            'password' => 'required'
        ]
    ];

}