<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
            ['id' => 1, 'name' => 'Дизайн', 'photo' => 'images/menu/design.png',  'created_at' => '2024-03-10 15:37:35', 'updated_at' => '2024-03-10 15:37:35'],
            ['id' => 2, 'name' => 'Разработка и ИТ', 'photo' => 'images/menu/it.png', 'created_at' => '2024-03-19 13:12:43', 'updated_at' => '2024-03-19 13:12:43'],
            ['id' => 3, 'name' => 'Тексты и переводы', 'photo' => 'images/menu/tex.png', 'created_at' => '2024-03-19 13:13:33', 'updated_at' => '2024-03-19 13:13:33'],
            ['id' => 4, 'name' => 'SEO и трафик', 'photo' => 'images/menu/seo.png', 'created_at' => '2024-03-19 13:13:53', 'updated_at' => '2024-03-19 13:13:53'],
            ['id' => 5, 'name' => 'Соцсети и реклама', 'photo' => 'images/menu/sic.png', 'created_at' => '2024-03-19 13:14:05', 'updated_at' => '2024-03-19 13:14:05'],
        ]);
    }
}
