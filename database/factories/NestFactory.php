<?php

namespace Database\Factories;

use App\Models\Nest;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class NestFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Nest::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'description' => Str::random(16),
            'nest_id' => '1',
            'uuid' => Str::random(32),
        ];
    }
}
