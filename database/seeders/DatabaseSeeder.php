<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Factories\HistoryFactory;
use Database\Factories\MonitorFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        MonitorFactory::new()
            ->has(HistoryFactory::new()->count(20), 'histories')
            ->createMany(10);
    }
}
