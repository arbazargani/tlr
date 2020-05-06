<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Alireza',
            'family' => 'Bazargnai',
            'email' => 'info@arbazargani.ir',
            'membership' => 'full',
            'admin' => 'true',
            'password' => bcrypt('09308990856')
        ]);
        DB::table('users')->insert([
            'name' => 'Siamak',
            'family' => 'Sazgar',
            'email' => 'info@sazgar.ir',
            'membership' => 'full',
            'admin' => 'true',
            'password' => bcrypt('siamak')
        ]);
        DB::table('users')->insert([
            'name' => 'Saeed',
            'family' => 'Khosravi',
            'email' => 'info@khosravi.ir',
            'membership' => 'free',
            'admin' => 'false',
            'password' => bcrypt('khosravi')
        ]);
    }
}
