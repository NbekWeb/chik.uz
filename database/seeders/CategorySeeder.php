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
            ['id' => 1, 'menu_id' => '1', 'name' => 'Полиграфия', 'photo' => 'exampleImage', 'photo_link' => 'storage/categories/image.png', 'url_link' => 'polygraphy', 'created_at' => '2024-03-10 15:37:35', 'updated_at' => '2024-03-10 15:37:35'],
            ['id' => 2, 'menu_id' => '1', 'name' => 'Интерьер и экстерьер', 'photo' => 'exampleImage', 'photo_link' => 'storage/categories/image.png', 'url_link' => 'interior-and-exterior', 'created_at' => '2024-03-19 13:12:43', 'updated_at' => '2024-03-19 13:12:43'],
            ['id' => 3, 'menu_id' => '1', 'name' => 'Наружная реклама', 'photo' => 'exampleImage', 'photo_link' => 'storage/categories/image.png', 'url_link' => 'outdoor-advertising', 'created_at' => '2024-03-19 13:13:33', 'updated_at' => '2024-03-19 13:13:33'],
            ['id' => 4, 'menu_id' => '1', 'name' => 'Обработка и редактирование', 'photo' => 'exampleImage', 'photo_link' => 'storage/categories/image.png', 'url_link' => 'processing-and-editing', 'created_at' => '2024-03-19 13:13:53', 'updated_at' => '2024-03-19 13:13:53'],
            ['id' => 5, 'menu_id' => '1', 'name' => 'Веб и мобильный дизайн', 'photo' => 'exampleImage', 'photo_link' => 'storage/categories/image.png', 'url_link' => 'web-and-mobile-design', 'created_at' => '2024-03-19 13:14:05', 'updated_at' => '2024-03-19 13:14:05'],
            ['id' => 6, 'menu_id' => '1', 'name' => 'Промышленный дизайн', 'photo' => 'exampleImage', 'photo_link' => 'storage/categories/image.png', 'url_link' => 'industrial-design', 'created_at' => '2024-03-19 13:14:18', 'updated_at' => '2024-03-19 13:14:18'],
            ['id' => 7, 'menu_id' => '1', 'name' => 'Арт и иллюстрации', 'photo' => 'exampleImage', 'photo_link' => 'storage/categories/image.png', 'url_link' => 'art-and-illustrations', 'created_at' => '2024-03-19 13:14:30', 'updated_at' => '2024-03-19 13:14:30'],
            ['id' => 8, 'menu_id' => '1', 'name' => 'Логотип и брендинг', 'photo' => 'exampleImage', 'photo_link' => 'storage/categories/image.png', 'url_link' => 'logo-and-branding', 'created_at' => '2024-03-19 13:14:45', 'updated_at' => '2024-03-19 13:14:45'],
            ['id' => 9, 'menu_id' => '1', 'name' => 'Презентации и инфографика', 'photo' => 'exampleImage', 'photo_link' => 'storage/categories/image.png', 'url_link' => 'presentations-and-infographics', 'created_at' => '2024-03-19 13:14:55', 'updated_at' => '2024-03-19 13:14:55'],
            ['id' => 11, 'menu_id' => '2', 'name' => 'Верстка', 'photo' => 'exampleImage', 'photo_link' => 'storage/categories/image.png', 'url_link' => 'layout', 'created_at' => '2024-03-19 13:15:13', 'updated_at' => '2024-03-19 13:15:13'],
            ['id' => 12, 'menu_id' => '2', 'name' => 'Скрипты и боты', 'photo' => 'exampleImage', 'photo_link' => 'storage/categories/image.png', 'url_link' => 'scripts-and-bots', 'created_at' => '2024-03-19 13:15:23', 'updated_at' => '2024-03-19 13:15:23'],
            ['id' => 13, 'menu_id' => '2', 'name' => 'Юзабилити, тесты и помощь', 'photo' => 'exampleImage', 'photo_link' => 'storage/categories/image.png', 'url_link' => 'usability-tests-and-help', 'created_at' => '2024-03-19 13:15:35', 'updated_at' => '2024-03-19 13:15:35'],
            ['id' => 14, 'menu_id' => '2', 'name' => 'Доработка и настройка сайта', 'photo' => 'exampleImage', 'photo_link' => 'storage/categories/image.png', 'url_link' => 'site-improvements-and-settings', 'created_at' => '2024-03-19 13:15:45', 'updated_at' => '2024-03-19 13:15:45'],
            ['id' => 15, 'menu_id' => '2', 'name' => 'Десктоп программирование', 'photo' => 'exampleImage', 'photo_link' => 'storage/categories/image.png', 'url_link' => 'desktop-programming', 'created_at' => '2024-03-19 13:16:02', 'updated_at' => '2024-03-19 13:16:02'],
            ['id' => 16, 'menu_id' => '2', 'name' => 'Мобильные приложения', 'photo' => 'exampleImage', 'photo_link' => 'storage/categories/image.png', 'url_link' => 'mobile-apps', 'created_at' => '2024-03-19 13:16:13', 'updated_at' => '2024-03-19 13:16:13'],
            ['id' => 17, 'menu_id' => '2', 'name' => 'Создание сайтов', 'photo' => 'exampleImage', 'photo_link' => 'storage/categories/image.png', 'url_link' => 'site-creation', 'created_at' => '2024-03-19 13:16:35', 'updated_at' => '2024-03-19 13:16:35'],
            ['id' => 18, 'menu_id' => '2', 'name' => 'Игры', 'photo' => 'exampleImage', 'photo_link' => 'storage/categories/image.png', 'url_link' => 'games', 'created_at' => '2024-03-19 13:16:49', 'updated_at' => '2024-03-19 13:16:49'],
            ['id' => 19, 'menu_id' => '2', 'name' => 'Сервера и хостинг', 'photo' => 'exampleImage', 'photo_link' => 'storage/categories/image.png', 'url_link' => 'servers-and-hosting', 'created_at' => '2024-03-19 13:17:03', 'updated_at' => '2024-03-19 13:17:03'],
            ['id' => 20, 'menu_id' => '3', 'name' => 'Набор текста', 'photo' => 'exampleImage', 'photo_link' => 'storage/categories/image.png', 'url_link' => 'text-typing', 'created_at' => '2024-03-19 13:17:18', 'updated_at' => '2024-03-19 13:17:18'],
            ['id' => 21, 'menu_id' => '3', 'name' => 'Резюме и вакансии', 'photo' => 'exampleImage', 'photo_link' => 'storage/categories/image.png', 'url_link' => 'resumes-and-vacancies', 'created_at' => '2024-03-19 13:17:31', 'updated_at' => '2024-03-19 13:17:31'],
            ['id' => 22, 'menu_id' => '3', 'name' => 'Тексты для сайтов и контент', 'photo' => 'exampleImage', 'photo_link' => 'storage/categories/image.png', 'url_link' => 'site-texts-and-content', 'created_at' => '2024-03-19 13:17:44', 'updated_at' => '2024-03-19 13:17:44'],
            ['id' => 23, 'menu_id' => '3', 'name' => 'Продажа и бизнес тексты', 'photo' => 'exampleImage', 'photo_link' => 'storage/categories/image.png', 'url_link' => 'sales-and-business-texts', 'created_at' => '2024-03-19 13:18:02', 'updated_at' => '2024-03-19 13:18:02'],
            ['id' => 24, 'menu_id' => '3', 'name' => 'Переводы', 'photo' => 'exampleImage', 'photo_link' => 'storage/categories/image.png', 'url_link' => 'translations', 'created_at' => '2024-03-19 13:18:14', 'updated_at' => '2024-03-19 13:18:14'],
            ['id' => 25, 'menu_id' => '4', 'name' => 'Статистика и аналитика', 'photo' => 'exampleImage', 'photo_link' => 'storage/categories/image.png', 'url_link' => 'statistics-and-analytics', 'created_at' => '2024-03-19 13:18:28', 'updated_at' => '2024-03-19 13:18:28'],
            ['id' => 26, 'menu_id' => '4', 'name' => 'Трафик', 'photo' => 'exampleImage', 'photo_link' => 'storage/categories/image.png', 'url_link' => 'traffic', 'created_at' => '2024-03-19 13:18:43', 'updated_at' => '2024-03-19 13:18:43'],
            ['id' => 27, 'menu_id' => '4', 'name' => 'Продвижение сайта в ТОП', 'photo' => 'exampleImage', 'photo_link' => 'storage/categories/image.png', 'url_link' => 'site-promotion-to-top', 'created_at' => '2024-03-19 13:18:56', 'updated_at' => '2024-03-19 13:18:56'],
            ['id' => 28, 'menu_id' => '4', 'name' => 'Контекстная реклама', 'photo' => 'exampleImage', 'photo_link' => 'storage/categories/image.png', 'url_link' => 'contextual-advertising', 'created_at' => '2024-03-19 13:19:07', 'updated_at' => '2024-03-19 13:19:07'],
            ['id' => 29, 'menu_id' => '4', 'name' => 'Маркетплейсы', 'photo' => 'exampleImage', 'photo_link' => 'storage/categories/image.png', 'url_link' => 'marketplaces', 'created_at' => '2024-03-19 13:19:18', 'updated_at' => '2024-03-19 13:19:18'],
            ['id' => 30, 'menu_id' => '5', 'name' => 'Базы данных', 'photo' => 'exampleImage', 'photo_link' => 'storage/categories/image.png', 'url_link' => 'databases', 'created_at' => '2024-03-19 13:19:34', 'updated_at' => '2024-03-19 13:19:34'],
            ['id' => 31, 'menu_id' => '5', 'name' => 'Реклама и PR', 'photo' => 'exampleImage', 'photo_link' => 'storage/categories/image.png', 'url_link' => 'advertising-and-pr', 'created_at' => '2024-03-19 13:19:44', 'updated_at' => '2024-03-19 13:19:44'],
            ['id' => 32, 'menu_id' => '5', 'name' => 'E-mail рассылки', 'photo' => 'exampleImage', 'photo_link' => 'storage/categories/image.png', 'url_link' => 'email-newsletters', 'created_at' => '2024-03-19 13:19:55', 'updated_at' => '2024-03-19 13:19:55'],
            ['id' => 33, 'menu_id' => '5', 'name' => 'SMM', 'photo' => 'exampleImage', 'photo_link' => 'storage/categories/image.png', 'url_link' => 'smm', 'created_at' => '2024-03-19 13:20:08', 'updated_at' => '2024-03-19 13:20:08'],
            ['id' => 34, 'menu_id' => '5', 'name' => 'Обучение и консультации', 'photo' => 'exampleImage', 'photo_link' => 'storage/categories/image.png', 'url_link' => 'training-and-consulting', 'created_at' => '2024-03-19 13:20:18', 'updated_at' => '2024-03-19 13:20:18'],
            ['id' => 35, 'menu_id' => '5', 'name' => 'Продажа сайтов', 'photo' => 'exampleImage', 'photo_link' => 'storage/categories/image.png', 'url_link' => 'site-sales', 'created_at' => '2024-03-19 13:20:29', 'updated_at' => '2024-03-19 13:20:29'],
        ]);
    }
}
