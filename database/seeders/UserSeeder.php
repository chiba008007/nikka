<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            'id' => 1,
            'name' => 'テストタロウ',
            'email' => 'chiba@innovation-gate.jp',
            'email_verified_at' => null,
            'password' => '$2y$12$4.jriNFM.7fLz1HxdJv3sO05VC0mXhktPiM4OABaWkxAi9foTjjCe',
            'remember_token' => null,
            'created_at' => '2026-03-07 14:15:18',
            'updated_at' => '2026-03-07 14:15:18',
        ]);
    }
}
