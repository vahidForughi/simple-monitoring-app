<?php

namespace Database\Factories;

use App\Models\Monitor;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Monitor>
 */
class MonitorFactory extends Factory
{
    protected $model = Monitor::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => Str::ulid(),
            'name' => fake()->name(),
            'interval' => fake()->numberBetween(1, 5),
            'url' => 'http://mobinnet.ir', // fake()->url(),
            'method' => 1, // fake()->randomElement(Monitor::METHOD),
            'body' => fake()->randomElement([
                null,
                [
                    'title' => fake()->title(),
                    'is_it' => fake()->boolean(),
                ]
            ]),
            'monitored_at' => fake()->dateTime(),
        ];
    }
}
