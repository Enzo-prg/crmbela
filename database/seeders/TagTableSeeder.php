<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $input = [
            [
                'name'        => 'produtos',
                'description' => 'produtos',
            ],
            

        ];

        foreach ($input as $tag) {
            Tag::create($tag);
        }
    }
}
