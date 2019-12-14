<?php

use Illuminate\Database\Seeder;
use App\Post;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1; $i <= 10; $i++) {
            Post::create([
                'user_id'         => $i,
                'title'           => 'これはテスト投稿' .$i,
                'study_book'      => 'これはテスト投稿' .$i,
                'body'            => 'これはテスト投稿' .$i,
                'result'          => 'これはテスト投稿' .$i,
                'reference_image' => 'https://placehold.jp/50x50.png',
                'created_at'      => now(),
                'updated_at'      => now()
            ]);
        }
    }
}
