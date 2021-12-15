<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Client;
use App\Models\Element;
use App\Models\Formula;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Status;
use App\Models\Tax;
use App\Models\User;
use App\Models\Vendor;
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
            'reports',
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
            [
                '2105' => 'polyester',
                '5021' => 'polyester',
                '2441-0' => 'polyester',
                '1770' => 'polyester',
                '2427' => 'polyester',
                'TGIC' => 'TGIC',
                'Epoxy' => 'Epoxy',
                'EJ1' => 'CaCO4',
                'SF3' => 'CaCO4',
                'synthetic BB-88' => 'BaSO4',
                'N220' => 'Black',
                '920' => 'Yellow',
                '218' => 'Titanium',
                'PV88' => 'leveling',
                'H955' => 'Benzoin',
                'HC68' => 'Matting Agent',
                '130' => 'Red',
                '170' => 'Red',
                '180' => 'Red',
                '48/2' => 'Red',
                '48/3' => 'Red',
                'middle chrome 34' => 'Yellow',
                'Lemon' => 'Yellow',
                '15:01' => 'Blue',
                '15:3' => 'Blue',
                'marine G58' => 'Blue',
                'R-104' => 'Orange',
                'green 7' => 'Green',
                '????' => 'Violet',
                'Printex-V (fine)' => 'Black',
                'Fine silver' => 'Aluminium Powder',
                'Sparcle Silver' => 'Aluminium Powder',
                'OK-214' => 'Grinding Powder',
            ];

        foreach ($elements as $k => $elem) {
            Element::factory()->create([
                'name' => $elem,
                'code' =>  $k,
            ]);
        }


        $clientStatuses = ['Lead', 'Contacted', 'Sample Requested', 'Sample Submitted', 'Order', 'Manufacturing', 'Rejected', 'Done', 'InActive'];
        $orderStatuses = ['pending', 'Manufacturing', 'done'];
        $billStatuses = ['unpaid', 'partial', 'paid'];
        $elementCategories = ['resin', 'hybrid', 'tgic', 'pigment', 'filler', 'additive'];

        foreach ($clientStatuses as $stat) {
            Status::factory()->create([
                'name' => $stat,
                'type' => 'client'
            ]);
        }
        foreach ($orderStatuses as $sta) {
            Status::factory()->create([
                'name' => $sta,
                'type' => 'order'
            ]);
        }
        foreach ($billStatuses as $st) {
            Status::factory()->create([
                'name' => $st,
                'type' => 'bill'
            ]);
        }

        foreach ($elementCategories as $cat) {
            Category::factory()->create([
                'name' => $cat,
                'type' => 'element'
            ]);
        }

        Category::factory()->create([
            'name' => 'formula',
            'type' => 'formula'
        ]);

        Category::factory()->create([
            'name' => 'product',
            'type' => 'product'
        ]);
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

        $settings = [
            'company' => 'Taco',
            'email' => '',
            'phone' => '',
            'address' => '',
            'city' => '',
            'state' => 'Giza',
            'country' => 'Egypt',
            'currency' => 'EGP',
            'due_to_days' => '14',
            'auto_send' => 0,
            'working_days' => 24,
            'working_hours' => 8,
            'avg_salary' => 2000,
            'element_last_price' => 0,
            'product_last_price' => 0,
        ];
        foreach ($settings as $key => $val) {
            Setting::factory()->create([
                'name' => $key,
                'value' => $val,
            ]);
        }


      //  User::factory(1000)->create();
     //   Formula::factory(10000)->create();
     //   Element::factory(50000)->create();
     //   Category::factory(6000)->create();
   //     Inventory::factory(700)->create();


//        Client::factory(50)->create();
//        Vendor::factory(10)->create();
//        Product::factory(10)->create();
    }
}
