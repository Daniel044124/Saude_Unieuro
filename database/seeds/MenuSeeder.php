<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('menus')->insert([
            ['name' => 'Itens', 'path' => '/items'],
            ['name' => 'Pedidos', 'path' => '/orders'],
            ['name' => 'Usuários', 'path' => '/users'],
            ['name' => 'Perfis', 'path' => '/roles'],
            ['name' => 'Menus', 'path' => '/menus'],
            ['name' => 'Novo pedido', 'path' => '/orders/new'],
            ['name' => 'Acessos', 'path' => '/permissions'],
            ['name' => 'Meus pedidos', 'path' => '/users/myorders'],
            ['name' => 'Laboratórios', 'path' => '/labs'],
            ['name' => 'Cursos', 'path' => '/courses'],
            ['name' => 'Turmas', 'path' => '/classes'],
            ['name' => 'Disciplinas', 'path' => '/subjects'],
        ]);
    }
}
