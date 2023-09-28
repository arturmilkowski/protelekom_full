<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('posts')->insert([
            'user_id' => 1,
            'slug' => 'witam-na-mojej-stronie',
            'title' => 'witam na mojej stronie',
            'intro' => 'To będzie piękna strona',
            'content' => 'I to jeszcze jak jak. Szok',
            'img' => 'witam-na-mojej-stronie.webp',
            'site_description' => 'Witam na mojej stronie. Zapraszam do zapoznania się z wpisami na blogu i produktami',
            'site_keyword' => 'strony www, witam',
            'approved' => '1',
            'published' => '1',
            'created_at' => '2023-07-01 22:11:22.000000',
            'updated_at' => '2023-07-07 22:11:22.000000',
        ]);
        DB::table('posts')->insert([
            'user_id' => 1,
            'slug' => 'post-1',
            'title' => 'Post 1',
            'intro' => '',
            'content' => '',
            'img' => 'post1.gif',
            'site_description' => '',
            'site_keyword' => '',
            'approved' => '1',
            'published' => '1',
            'created_at' => '2023-08-01 22:11:22.000000',
            'updated_at' => '2023-08-07 22:11:22.000000',
        ]);
        DB::table('posts')->insert([
            'user_id' => 2,
            'slug' => 'post-2',
            'title' => 'Post 2',
            'intro' => '',
            'content' => '',
            'img' => 'post1.gif',
            'site_description' => '',
            'site_keyword' => '',
            'approved' => '1',
            'published' => '1',
            'created_at' => '2023-09-01 22:11:22.000000',
            'updated_at' => '2023-09-07 22:11:22.000000',
        ]);
    }
}
