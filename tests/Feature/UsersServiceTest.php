<?php namespace Test\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Services\UsersService;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UsersServiceTest extends TestCase{

    use RefreshDatabase;    
    public function test_create_user_with_real_data(){
        $usersService = $this->app->make(UsersService::class);
        $this->assertNotNull($usersService);
        $this->assertInstanceOf(UsersService::class, $usersService);

        $admin_role = Role::create(['name' => 'admin']);
        $this->assertNotNull($admin_role);
        $this->assertInstanceOf(Role::class, $admin_role);

        $user_data = [
            'name' => 'Ivan Alvarado',
            'email' => 'ivan.alvarado@serprogramador.es',
            'password' => 'inariama1110',
            'password_confirmation' => 'inariama1110',
            'role_id' => $admin_role->id
        ];
        $user = $usersService->create($user_data);
        $this->assertNotNull($user, $usersService->errors()->first());
        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('Ivan Alvarado', $user->name);
        $this->assertEquals('ivan.alvarado@serprogramador.es', $user->email);
        $this->assertTrue( Hash::check('inariama1110', $user->password) );
        $this->assertGreaterThan(0,$user->roles()->count());
        $this->assertEquals($admin_role->id, $user->roles()->first()->id);
    }

}