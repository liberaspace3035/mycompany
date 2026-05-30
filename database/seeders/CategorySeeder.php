<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            ['slug' => 'tech',     'name' => 'Tech',     'color' => '#56847A', 'position' => 1],
            ['slug' => 'ai',       'name' => 'AI Agent', 'color' => '#34403D', 'position' => 2],
            ['slug' => 'business', 'name' => 'Business', 'color' => '#ACADA4', 'position' => 3],
            ['slug' => 'design',   'name' => 'Design',   'color' => '#56847A', 'position' => 4],
        ];

        foreach ($rows as $row) {
            Category::query()->updateOrCreate(['slug' => $row['slug']], $row);
        }
    }
}
