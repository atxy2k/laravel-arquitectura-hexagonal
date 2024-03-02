<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class CreateDefaultPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // Almacenes
            'view any almacen',
            'view single almacen',
            'add almacen',
            'change almacen',
            'delete almacen',
            // Departamentos
            'view any departamento',
            'view single departamento',
            'add departamento',
            'change departamento',
            'delete departamento',
            // Marcas
            'view any marca',
            'view single marca',
            'add marca',
            'change marca',
            'delete marca',
            // Users
            'view any user',
            'view single user',
            'add user',
            'change user',
            'delete user',
            // Roles
            'view any role',
            'view single role',
            'add role',
            'change role',
            'delete role',
            // Productos
            'view any role',
            'view single product',
            'add product',
            'change product',
            'delete product',
        ];
        foreach($permissions as $permission){
            if(!Permission::where('name', $permission)->exists()){
                Permission::create(['name' => $permission]);
            }
        }
    }
}
