<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class FeedbackPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $this->permissions = [
            'dashboard',
            'accounting',
            'role-show',
            'role-edit',
            'role-create',
            'role-delete',
            'admin-show',
            'admin-edit',
            'admin-invite',
            'admin-delete',
            'tenant-show',
            'tenant-edit',
            'tenant-create',
            'tenant-delete',
        ];
        foreach ($this->permissions as $permission){
            Permission::create(['guard_name' => 'admin', 'name' => $permission]);
        }
        $permission = Permission::create(['guard_name' => 'admin', 'name' => 'publish articles']);
        $role1 = Role::create(['guard_name' => 'admin', 'name' => 'viewer']);
        $role1->givePermissionTo('role-show');
        $role1->givePermissionTo('admin-show');
        $role1->givePermissionTo('tenant-show');

        $role2 = Role::create(['guard_name' => 'admin', 'name' => 'admin']);
        $role2->givePermissionTo('admin-invite');
        $role2->givePermissionTo('admin-show');
        $role2->givePermissionTo('tenant-create');
        $role2->givePermissionTo('tenant-show');

        $role3 = Role::create(['guard_name' => 'admin', 'name' => 'Feedback']);
        // gets all permissions via Gate::before rule; see AuthServiceProvider

        // create demo users
        $password = Hash::make('viewer@feedback.com');
        $admin = \App\Models\Admin::factory()->create([
            'name' => 'viewer',
            'email' => 'viewer@taco.com',
            'password'=>$password,
        ]);
        $admin->assignRole($role1);

        $password = Hash::make('admin@feedback.com');
        $admin = \App\Models\Admin::factory()->create([
            'name' => 'admin',
            'email' => 'admin@feedback.com',
            'password'=>$password,
        ]);
        $admin->assignRole($role2);

        $password = Hash::make('feedback');
        $admin = \App\Models\Admin::factory()->create([
            'name' => 'feedback',
            'email' => 'feedback@feedback.com',
            'password'=>$password,
        ]);
        $admin->assignRole($role3);
    }
}
