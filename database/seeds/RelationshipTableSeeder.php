<?php

use Illuminate\Database\Seeder;
use App\Relationship;

class RelationshipTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         for ($i = 2; $i <= 10; $i++) {
            Relationship::create([
                'following_id' => $i,
                'followed_id' => 1
            ]);
        }
    }
}
