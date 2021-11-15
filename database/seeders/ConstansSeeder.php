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


        $elements =
['Polyster GH-1770',
'Polyster 3305',
'Epoxy E12-(903)',
'Polyster GH-5021',
'TGIC',
'THR218',
'HyrdoCarb 90',
'BB1 (BaSo4)',
'BB-88',
'PV 88',
'BENZOIN ',
'XG605',
'YELLOW  920',
'black 306',
'RED 180 m',
'RED 130 m',
'Yellow 3910',
'blue 15/3 ',
'Printex V',
'Powder add 9083',
'Plustalc 1250',
'violet',
'green 7',
'OKAY (1gm/ kg) (15 kg/bag)',
'Alu-c',
'Aerosil 200',
'Red 170 (Dcc red 7470)',
'Yellow 1012 (Medium chrome yellow)',
' Blue 15/1 ',
'Ora. Molbedate 1610 R104',
'EJ1',
'cap. 381-20',
'blue.G-58',
'RED 57/1',
'RED 48/2',
'Black N220',
'yellow 1080 (lemon)',
'DE3329 Matting Agent',
'HC68 Matting Hardner',
'silver 9407',
'gold 9604',
'cu.',
'Al. fine badaw',
'Al. grains badawy'];



    }
}
