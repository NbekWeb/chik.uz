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
            ['id' => 1, 'name' => 'Дизайн', 'photo' => 'exampleImage', 'photo_link' => 'storage/menu/image.png', 'url_link' => 'design', 'created_at' => '2024-03-10 15:37:35', 'updated_at' => '2024-03-10 15:37:35'],
            ['id' => 2, 'name' => 'Разработка и ИТ', 'photo' => 'exampleImage', 'photo_link' => 'storage/menu/image.png', 'url_link' => 'development-and-it', 'created_at' => '2024-03-19 13:12:43', 'updated_at' => '2024-03-19 13:12:43'],
            ['id' => 3, 'name' => 'Тексты и переводы', 'photo' => 'exampleImage', 'photo_link' => 'storage/menu/image.png', 'url_link' => 'texts-and-translations', 'created_at' => '2024-03-19 13:13:33', 'updated_at' => '2024-03-19 13:13:33'],
            ['id' => 4, 'name' => 'SEO и трафик', 'photo' => 'exampleImage', 'photo_link' => 'storage/menu/image.png', 'url_link' => 'seo-and-traffic', 'created_at' => '2024-03-19 13:13:53', 'updated_at' => '2024-03-19 13:13:53'],
            ['id' => 5, 'name' => 'Соцсети и реклама', 'photo' => 'exampleImage', 'photo_link' => 'storage/menu/image.png', 'url_link' => 'social-networks-and-advertising', 'created_at' => '2024-03-19 13:14:05', 'updated_at' => '2024-03-19 13:14:05'],

        ]);
    }
}
