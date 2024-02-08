<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'name' => 'Fajar',
            'balance' => 150,
        ]);
        \App\Models\User::create([
            'name' => 'Stepen',
            'balance' => 100,
        ]);
    }
}
