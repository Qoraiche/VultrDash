<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

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
            'firstname'      => '',
            'lastname'       => '',
            'country'        => '',
            'email'          => 'admin@example.com',
            'password'       => bcrypt('admin'),
            'remember_token' => str_random(10),
            'created_at'     => Carbon::now()->toDateTimeString(),
            'updated_at'     => Carbon::now()->toDateTimeString(),
        ]);
    }
}
