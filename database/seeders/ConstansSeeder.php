<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Element;
use App\Models\Inventory;
use App\Models\Status;
use App\Models\Tax;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class ConstansSeeder extends Seeder
{
    /**
     * @var string[]
     */
    private $permissions;

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
            'hr',
            'formulas',
            'crm',
            'purchases',
            'inventory',
            'production',
            'sales',
           'setting'
        ];
        foreach ($this->permissions as $permission) {
            Permission::create(['guard_name' => 'web', 'name' => $permission]);
        }

        $role1 = Role::create(['guard_name' => 'web', 'name' => 'accountant']);
        $role1->givePermissionTo('purchases');
        $role1->givePermissionTo('sales');

        $role2 = Role::create(['guard_name' => 'web', 'name' => 'admin']);
        $role2->givePermissionTo('hr');
        $role2->givePermissionTo('crm');
        $role2->givePermissionTo('purchases');
        $role2->givePermissionTo('inventory');
        $role2->givePermissionTo('sales');
        $role2->givePermissionTo('setting');

        $role3 = Role::create(['guard_name' => 'web', 'name' => 'Feedback']);
        // gets all permissions via Gate::before rule; see AuthServiceProvider

        // create demo users
        $password = Hash::make('accountant@taco.com');
        $user = \App\Models\User::factory()->create([
            'name' => 'accountant',
            'email' => 'accountant@taco.com',
            'password' => $password,
        ]);
        $user->assignRole($role1);

        $password = Hash::make('admin@taco.com');
        $user = \App\Models\User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@taco.com',
            'password' => $password,
        ]);
        $user->assignRole($role2);
        $password = Hash::make('feedback');

        $user = \App\Models\User::factory()->create([
            'name' => 'feedback',
            'email' => 'feedback@taco.com',
            'password' => $password,
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

//        foreach ($elements as $elem){
//            Element::factory()->create([
//                'name' => $elem,
//                'code' => $elem,
//            ]);
//        }


        $clientStatuses = ['Lead', 'Contacted', 'Sample Requested', 'Sample Submitted', 'Order', 'Manufacturing', 'Rejected', 'Done', 'InActive'];
        $orderStatuses = ['pending','Manufacturing','done'];
        $billStatuses = ['unpaid','partial','paid'];
        $elementCategories = ['RawMaterialCategory', 'Epoxy Resin', 'Polyester Resin', 'Organic Pigments', 'Oxides', 'Additives', 'Fillers'];

        foreach ($clientStatuses as $stat){
            Status::factory()->create([
                'name' => $stat,
                'type' => 'client'
            ]);
        }
        foreach ($orderStatuses as $sta){
            Status::factory()->create([
                'name' => $sta,
                'type' => 'order'
            ]);
        }
        foreach ($billStatuses as $st){
            Status::factory()->create([
                'name' => $st,
                'type' => 'bill'
            ]);
        }

        foreach ($elementCategories as $cat){
            Category::factory()->create([
                'name' => $cat,
                'type' => 'element'
            ]);
        }

        Inventory::factory()->create([
            'name' => 'main',
            'type' => 'materials',
            'location' => 'factory',
        ]);
        Inventory::factory()->create([
            'name' => 'final product',
            'type' => 'products',
            'location' => 'factory',
        ]);

        Tax::factory()->create([
            'name' => 'VAT',
            'percent' => '14',
        ]);
    }
}
