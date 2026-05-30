<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 管理者アカウント。本番は ADMIN_EMAIL / ADMIN_PASSWORD 環境変数で上書き可。
        User::query()->updateOrCreate(
            ['email' => env('ADMIN_EMAIL', 'admin@liberaspace.local')],
            [
                'name' => env('ADMIN_NAME', 'Admin'),
                'password' => Hash::make(env('ADMIN_PASSWORD', 'password')),
                'email_verified_at' => now(),
            ],
        );

        $this->call([
            SiteSettingSeeder::class,
            CategorySeeder::class,
            PageSeeder::class,
            ServiceSeeder::class,
            WorkSeeder::class,
            PostSeeder::class,
            TimelineSeeder::class,
            SkillSeeder::class,
        ]);
    }
}
