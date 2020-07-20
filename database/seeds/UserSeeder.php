<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\User::create([
            'username' => 'Roberta Thuani',
            'email' => 'robertathuani@gmail.com',
            'password' => \Illuminate\Support\Facades\Hash::make('123456'),
            'role_id' => 1
        ]);
    }
}
