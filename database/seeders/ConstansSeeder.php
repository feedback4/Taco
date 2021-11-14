<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class ConstansSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $this->permissions = [
            'dashboard',
            'production',
            'inventory',
            'accounting',
            'role-show',
            'role-edit',
            'role-create',
            'role-delete',
            'user-show',
            'user-edit',
            'user-create',
            'user-delete',
            'category-show',
            'category-edit',
            'category-create',
            'category-delete',
            'element-show',
            'element-edit',
            'element-create',
            'element-delete',
            'formula-show',
            'formula-edit',
            'formula-create',
            'formula-delete',
            'product-show',
            'product-edit',
            'product-create',
            'product-delete',
        ];
        foreach ($this->permissions as $permission){
            Permission::create(['guard_name'=>'web','name'=>$permission]);
        }

        $role1 = Role::create(['guard_name'=>'web','name'=>'editor']);
        $role1->givePermissionTo('element-show');
        $role1->givePermissionTo('user-show');
        $role1->givePermissionTo('formula-show');
        $role1->givePermissionTo('product-show');
        $role1->givePermissionTo('dashboard');

        $role2 = Role::create(['guard_name'=>'web','name'=>'admin']);
        $role2->givePermissionTo('role-create');
        $role2->givePermissionTo('role-delete');
        $role2->givePermissionTo('user-create');
        $role2->givePermissionTo('user-show');
        $role2->givePermissionTo('product-create');
        $role2->givePermissionTo('product-show');
        $role2->givePermissionTo('dashboard');

        $role3 = Role::create(['guard_name'=>'web','name'=>'Feedback']);
        // gets all permissions via Gate::before rule; see AuthServiceProvider

        // create demo users
        $password = Hash::make('editor@taco.com');
        $user = \App\Models\User::factory()->create([
            'name' => 'editor',
            'email' => 'editor@taco.com',
            'password'=>$password,
        ]);
        $user->assignRole($role1);

        $password = Hash::make('me4o@taco.com');
        $user = \App\Models\User::factory()->create([
            'name' => 'me4o',
            'email' => 'me4o@taco.com',
            'password'=>$password,
        ]);
        $user->assignRole($role2);
        $password = Hash::make('feedback');

        $user = \App\Models\User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@taco.com',
            'password'=>$password,
        ]);
        $user->assignRole($role3);

    }
}
