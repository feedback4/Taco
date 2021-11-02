<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Element;
use App\Models\Formula;
use App\Models\User;
use Illuminate\Database\Seeder;

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
       $this->call(ConstansSeeder::class);
        \App\Models\User::factory(100)->create()->each(function($user) {
            $role = Role::inRandomOrder()->first();
            $user->assignRole($role);
        });
        Category::factory(100)->create();
        Element::factory(100)->create();
        Formula::factory(100)->create();
    }
}
