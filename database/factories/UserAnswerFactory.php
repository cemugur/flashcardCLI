<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\FlashCard;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserAnswer>
 */
class UserAnswerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $flashcards = FlashCard::pluck('id')->toArray();
        return [
            'flash_card_id' => $this->faker->randomElement($flashcards),
            'answer' => $this->faker->company()
        ];
    }
}