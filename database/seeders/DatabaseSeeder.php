<?php

namespace Database\Seeders;


use App\Models\Category;
use App\Models\Element;


use App\Models\Admin;
use App\Models\Formula;
use App\Models\Inventory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\Hash;
use Spatie\Multitenancy\Models\Tenant;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */


    public function run()
    {

        tenant()
            ? $this->runTenantSpecificSeeders()
            : $this->runLandlordSpecificSeeders();
    }

    public function runTenantSpecificSeeders()
    {
        $this->call(ConstansSeeder::class);
        \App\Models\User::factory(10)->create()->each(function ($user) {
            $role = Role::inRandomOrder()->first();
            $user->assignRole($role);
        });
        Category::factory()->create([
            'name' => 'filler',
            'type' => 'element'
        ]);
        Category::factory(10)->create();
        Element::factory(50)->create();

//        Formula::factory(10000)->create();

        Inventory::factory()->create([
           'name' => 'Main',
           'location' => 'factory',
        ]);
        Inventory::factory(2)->create();
     //   Formula::factory(100)->create();
    }
    /** @var  $factory */
    public function runLandlordSpecificSeeders()
    {
//        Admin::factory()->create([
//                'name' => 'ahmed badr',
//                'email' => 'a@mail.com',
//                'password' => Hash::make('feedback')
//            ]);
        $this->call(FeedbackPermissionSeeder::class);
    }
}
