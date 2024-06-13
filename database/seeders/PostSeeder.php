<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $post = Post::create([
            'user_id' => 2,
            'category_id' => 18,
            'title' =>'Game Developer',
            'slug' =>'game-developer',
            'body' => 'I`m game developer Lorem ipsum dolor sit amet consectetur adipisicing elit. Quae quisquam fuga a dolores sit voluptas.',
            'price' => '225000.12'

        ]);
    }
}
