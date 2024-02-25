<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\App;
use App\Services\UsersService;

class GenerateDefaultRolesAndUser extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin_role = Role::where('name','admin')->first();
        if(is_null($admin_role)){
            $admin_role = Role::create(['name' => 'admin']);
        }
        $admin_user = User::where('email', 'ivan.alvarado@serprogramador.es')->first();
        if(is_null($admin_user)){
            $usersService = App::make(UsersService::class);
            $user_data = [
                'name' => 'Ivan Alvarado',
                'email' => 'ivan.alvarado@serprogramador.es',
                'password' => 'inariama1110',
                'password_confirmation' => 'inariama1110',
                'role_id' => $admin_role->id
            ];
            $usersService->create($user_data);
        }
    }
}
