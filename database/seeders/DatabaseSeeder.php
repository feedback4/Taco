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
