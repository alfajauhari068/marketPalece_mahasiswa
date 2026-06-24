<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['Desain Grafis'],
            ['Pemrograman'],
            ['Penulisan'],
            ['Penerjemahan'],
            ['Video Editing'],
            ['Musik dan Audio'],
        ];

        foreach ($categories as $category) {
            DB::table('categories')->updateOrInsert([
                'name' => $category[0],
            ], [
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
