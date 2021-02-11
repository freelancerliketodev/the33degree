<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        \App\Models\User::create([
            'name' => 'Test',
            'email' => 'test1@gmail.com',
            'password' => bcrypt('Password'),            
        ]);

        \App\Models\Operator::create([
            'name' => 'Paypal',
        ]);
    }
}
