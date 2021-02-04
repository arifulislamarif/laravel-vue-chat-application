<?php

namespace Database\Factories;

use App\Models\Message;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class MessageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Message::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->sentence($nbWords = 10, $variableNbWords = true);

        return [
            'to' => User::inRandomOrder()->first()->id,
            'from' => User::inRandomOrder()->first()->id,
            'message' => $title,
        ];
    }
}
