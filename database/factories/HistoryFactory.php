<?php

namespace Database\Factories;

use App\Models\History;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Monitor>
 */
class HistoryFactory extends Factory
{
    protected $model = History::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => fake()->uuid(),
            'monitor_id' => MonitorFactory::new(),
            'status_code' => fake()->numberBetween(100, 599),
            'created_at' => fake()->dateTimeBetween(now()->subtract('20 day'), now()),
        ];
    }
}
