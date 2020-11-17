<?php

use App\User;
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
        $data = [
            [
                'username' => 'Samuel Felipe',
                'email' => 'samfelgar@gmail.com',
                'password' => \Illuminate\Support\Facades\Hash::make('123456'),
                'role_id' => 1
            ],
            [
                'username' => 'Santana',
                'email' => 'santana@gmail.com',
                'password' => \Illuminate\Support\Facades\Hash::make('123456'),
                'role_id' => 3
            ],
            [
                'username' => 'Roberta Thuani',
                'email' => 'robertathuani@gmail.com',
                'password' => \Illuminate\Support\Facades\Hash::make('123456'),
                'role_id' => 2
            ],
        ];

        foreach ($data as $user) {
            User::create($user);
        }
    }
}
