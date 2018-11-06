<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'firstname' => '',
            'lastname' => '',
            // 'address' => $faker->address,
            // 'city' => $faker->city,
            // 'zipcode' => $faker->postcode,
            'country' => '',
            // 'company' => $faker->company,
            // 'email' => $faker->unique()->safeEmail,
            'email' => 'admin',
            'password' => bcrypt('admin'),
            'remember_token' => str_random(10),
            'created_at' => Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon::now()->toDateTimeString()
        ]);

    }
}