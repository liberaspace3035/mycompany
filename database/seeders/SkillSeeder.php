<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            ['category' => 'Frontend', 'name' => 'TypeScript',  'level' => 92],
            ['category' => 'Frontend', 'name' => 'Next.js',     'level' => 88],
            ['category' => 'Frontend', 'name' => 'React',       'level' => 90],
            ['category' => 'Frontend', 'name' => 'Astro',       'level' => 78],
            ['category' => 'Frontend', 'name' => 'Three.js',    'level' => 70],
            ['category' => 'Backend',  'name' => 'Laravel',     'level' => 94],
            ['category' => 'Backend',  'name' => 'PHP',         'level' => 92],
            ['category' => 'Backend',  'name' => 'PostgreSQL',  'level' => 85],
            ['category' => 'Backend',  'name' => 'WordPress',   'level' => 88],
            ['category' => 'AI',       'name' => 'Claude Code', 'level' => 95],
            ['category' => 'AI',       'name' => 'Cursor',      'level' => 92],
            ['category' => 'AI',       'name' => 'Gemini',      'level' => 82],
            ['category' => 'Infra',    'name' => 'AWS',         'level' => 80],
            ['category' => 'Infra',    'name' => 'Cloudflare',  'level' => 84],
            ['category' => 'Infra',    'name' => 'Railway',     'level' => 78],
        ];

        foreach ($rows as $i => $r) {
            Skill::query()->updateOrCreate(
                ['category' => $r['category'], 'name' => $r['name']],
                ['level' => $r['level'], 'position' => $i],
            );
        }
    }
}
