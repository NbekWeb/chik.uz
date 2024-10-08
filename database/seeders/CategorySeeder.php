<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            ['id' => 1, 'menu_id' => '1', 'name' => 'Полиграфия', 'photo' => 'images/categories/polig.jpg', 'created_at' => '2024-03-10 15:37:35', 'updated_at' => '2024-03-10 15:37:35'],
            ['id' => 2, 'menu_id' => '1', 'name' => 'Интерьер и экстерьер', 'photo' => 'images/categories/integer.png', 'created_at' => '2024-03-19 13:12:43', 'updated_at' => '2024-03-19 13:12:43'],
            ['id' => 3, 'menu_id' => '1', 'name' => 'Наружная реклама', 'photo' => 'images/categories/narujnaya.jpg', 'created_at' => '2024-03-19 13:13:33', 'updated_at' => '2024-03-19 13:13:33'],
            ['id' => 4, 'menu_id' => '1', 'name' => 'Обработка и редактирование', 'photo' => 'images/categories/obro.jpg', 'created_at' => '2024-03-19 13:13:53', 'updated_at' => '2024-03-19 13:13:53'],
            ['id' => 5, 'menu_id' => '1', 'name' => 'Веб и мобильный дизайн', 'photo' => 'images/categories/web.jpg', 'created_at' => '2024-03-19 13:14:05', 'updated_at' => '2024-03-19 13:14:05'],
            ['id' => 6, 'menu_id' => '1', 'name' => 'Промышленный дизайн', 'photo' => 'images/categories/pro.jpg', 'created_at' => '2024-03-19 13:14:18', 'updated_at' => '2024-03-19 13:14:18'],
            ['id' => 7, 'menu_id' => '1', 'name' => 'Арт и иллюстрации', 'photo' => 'images/categories/art.jpg', 'created_at' => '2024-03-19 13:14:30', 'updated_at' => '2024-03-19 13:14:30'],
            ['id' => 8, 'menu_id' => '1', 'name' => 'Логотип и брендинг', 'photo' => 'images/categories/logotipy.jpg', 'created_at' => '2024-03-19 13:14:45', 'updated_at' => '2024-03-19 13:14:45'],
            ['id' => 9, 'menu_id' => '1', 'name' => 'Презентации и инфографика', 'photo' => 'images/categories/prez.jpg', 'created_at' => '2024-03-19 13:14:55', 'updated_at' => '2024-03-19 13:14:55'],
            ['id' => 11, 'menu_id' => '2', 'name' => 'Верстка', 'photo' => 'images/categories/Верстка.png', 'created_at' => '2024-03-19 13:15:13', 'updated_at' => '2024-03-19 13:15:13'],
            ['id' => 12, 'menu_id' => '2', 'name' => 'Скрипты и боты', 'photo' => 'images/categories/Скрипты.png', 'created_at' => '2024-03-19 13:15:23', 'updated_at' => '2024-03-19 13:15:23'],
            ['id' => 13, 'menu_id' => '2', 'name' => 'Юзабилити, тесты и помощь', 'photo' => 'images/categories/usablity.png', 'created_at' => '2024-03-19 13:15:35', 'updated_at' => '2024-03-19 13:15:35'],
            ['id' => 14, 'menu_id' => '2', 'name' => 'Доработка и настройка сайта', 'photo' => 'images/categories/настройкасайта.png', 'created_at' => '2024-03-19 13:15:45', 'updated_at' => '2024-03-19 13:15:45'],
            ['id' => 15, 'menu_id' => '2', 'name' => 'Десктоп программирование', 'photo' => 'images/categories/Десктоп.png', 'created_at' => '2024-03-19 13:16:02', 'updated_at' => '2024-03-19 13:16:02'],
            ['id' => 16, 'menu_id' => '2', 'name' => 'Мобильные приложения', 'photo' => 'images/categories/app.png', 'created_at' => '2024-03-19 13:16:13', 'updated_at' => '2024-03-19 13:16:13'],
            ['id' => 17, 'menu_id' => '2', 'name' => 'Создание сайтов', 'photo' => 'images/categories/Созданиесайтов.png', 'created_at' => '2024-03-19 13:16:35', 'updated_at' => '2024-03-19 13:16:35'],
            ['id' => 18, 'menu_id' => '2', 'name' => 'Игры', 'photo' => 'images/categories/game.png', 'created_at' => '2024-03-19 13:16:49', 'updated_at' => '2024-03-19 13:16:49'],
            ['id' => 19, 'menu_id' => '2', 'name' => 'Сервера и хостинг', 'photo' => 'images/categories/servera.png', 'created_at' => '2024-03-19 13:17:03', 'updated_at' => '2024-03-19 13:17:03'],
            ['id' => 20, 'menu_id' => '3', 'name' => 'Набор текста', 'photo' => 'images/categories/Набортекста.png', 'created_at' => '2024-03-19 13:17:18', 'updated_at' => '2024-03-19 13:17:18'],
            ['id' => 21, 'menu_id' => '3', 'name' => 'Резюме и вакансии', 'photo' => 'images/categories/Резюме.png', 'created_at' => '2024-03-19 13:17:31', 'updated_at' => '2024-03-19 13:17:31'],
            ['id' => 22, 'menu_id' => '3', 'name' => 'Тексты для сайтов и контент', 'photo' => 'images/categories/наполнениесайта.png', 'created_at' => '2024-03-19 13:17:44', 'updated_at' => '2024-03-19 13:17:44'],
            ['id' => 23, 'menu_id' => '3', 'name' => 'Продажа и бизнес тексты', 'photo' => 'images/categories/бизнестексты.png', 'created_at' => '2024-03-19 13:18:02', 'updated_at' => '2024-03-19 13:18:02'],
            ['id' => 24, 'menu_id' => '3', 'name' => 'Переводы', 'photo' => 'images/categories/Переводы.png', 'created_at' => '2024-03-19 13:18:14', 'updated_at' => '2024-03-19 13:18:14'],
            ['id' => 25, 'menu_id' => '4', 'name' => 'Статистика и аналитика', 'photo' => 'images/categories/Статистика.png', 'created_at' => '2024-03-19 13:18:28', 'updated_at' => '2024-03-19 13:18:28'],
            ['id' => 26, 'menu_id' => '4', 'name' => 'Трафик', 'photo' => 'images/categories/Трафик.png', 'created_at' => '2024-03-19 13:18:43', 'updated_at' => '2024-03-19 13:18:43'],
            ['id' => 27, 'menu_id' => '4', 'name' => 'Продвижение сайта в ТОП', 'photo' => 'images/categories/Продвижениесайта.png', 'created_at' => '2024-03-19 13:18:56', 'updated_at' => '2024-03-19 13:18:56'],
            ['id' => 28, 'menu_id' => '4', 'name' => 'Контекстная реклама', 'photo' => 'images/categories/Контекстнаяреклама.png', 'created_at' => '2024-03-19 13:19:07', 'updated_at' => '2024-03-19 13:19:07'],
            ['id' => 29, 'menu_id' => '4', 'name' => 'Маркетплейсы', 'photo' => 'images/categories/Маркетплейсы.png', 'created_at' => '2024-03-19 13:19:18', 'updated_at' => '2024-03-19 13:19:18'],
            ['id' => 30, 'menu_id' => '5', 'name' => 'Базы данных', 'photo' => 'images/categories/Базыданных.png', 'created_at' => '2024-03-19 13:19:34', 'updated_at' => '2024-03-19 13:19:34'],
            ['id' => 31, 'menu_id' => '5', 'name' => 'Реклама и PR', 'photo' => 'images/categories/Реклама.png', 'created_at' => '2024-03-19 13:19:44', 'updated_at' => '2024-03-19 13:19:44'],
            ['id' => 32, 'menu_id' => '5', 'name' => 'E-mail рассылки', 'photo' => 'images/categories/Email.png', 'created_at' => '2024-03-19 13:19:55', 'updated_at' => '2024-03-19 13:19:55'],
            ['id' => 33, 'menu_id' => '5', 'name' => 'SMM', 'photo' => 'images/categories/SMM.png', 'created_at' => '2024-03-19 13:20:08', 'updated_at' => '2024-03-19 13:20:08'],
            ['id' => 34, 'menu_id' => '5', 'name' => 'Обучение и консультации', 'photo' => 'images/categories/Обучение.png', 'created_at' => '2024-03-19 13:20:18', 'updated_at' => '2024-03-19 13:20:18'],
            ['id' => 35, 'menu_id' => '5', 'name' => 'Продажа сайтов', 'photo' => 'images/categories/Продажа.png', 'created_at' => '2024-03-19 13:20:29', 'updated_at' => '2024-03-19 13:20:29'],
        ]);
    }
}
