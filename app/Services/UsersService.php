<?php namespace App\Services;

use App\Infrastructure\BaseService;
use App\Models\User;
use App\Validators\UsersValidator;
use Throwable;
use Exception;
use Spatie\Permission\Models\Role;
use App\Throwables\Roles\RoleNotFoundException;
use App\Throwables\Users\UserCouldNotBeCreatedException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UsersService extends BaseService {

    public function __construct(UsersValidator $usersValidator){
        parent::__construct();
        $this->validator = $usersValidator;
    }

    public function create(array $data) : ?User{
        $return = null;
        try
        {
            DB::beginTransaction();
            throw_unless($this->validator->with($data)->passes(UsersValidator::CREATE), 
                new Exception($this->validator->errors()->first()));
            $role = Role::findById($data['role_id']);
            throw_if(is_null($role), RoleNotFoundException::class);
            $user_data = Arr::only($data, ['name', 'email', 'password']);
            $user_data['password'] = bcrypt($user_data['password']);
            $user = User::create($user_data);
            throw_if(is_null($user), UserCouldNotBeCreatedException::class);
            $user->assignRole($role->name);
            DB::commit();
            $return = $user;
        }
        catch(Throwable $e)
        {
            DB::rollBack();
            $this->pushError($e->getMessage());
        }
        return $return;
    }

    public function login(array $data) : bool {
        $return = false;
        try
        {
            throw_unless($this->validator->with($data)->passes(UsersValidator::LOGIN), new Exception('Parámetros inválidos'));
            throw_unless(Auth::attempt(Arr::only($data, ['email', 'password'])), new Exception('Usuario o contraseña incorrectos'));
            $return = true;
        }
        catch(Throwable $e)
        {
            $this->pushError($e->getMessage());
        }
        return $return;
    }

    public function logout() : void{
        Auth::logout();
    }

}