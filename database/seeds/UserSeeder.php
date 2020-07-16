<?php

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        User::create([
            'name' => 'Artur Júnior',
            'email' => 'artur.junior@soluti.com.br',
            'password' => Hash::make('123456'),
        ]);
    }
}
