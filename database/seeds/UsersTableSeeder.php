<?php

use Faker\Generator as Faker;

use Illuminate\Database\Seeder;

use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run( Faker $faker )
    {

        DB::table('users')->insert([
            'firstname' => $faker->firstname,
            'lastname' => $faker->lastname,
            // 'address' => $faker->address,
            // 'city' => $faker->city,
            // 'zipcode' => $faker->postcode,
            'country' => $faker->country,
            // 'company' => $faker->company,
            // 'email' => $faker->unique()->safeEmail,
            'email' => 'qoraicheofficiel@hotmail.com',
            'password' => bcrypt('vbspiders'),
            'remember_token' => str_random(10),
            'created_at' => Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon::now()->toDateTimeString()
        ]);

    }
}
