<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FlashCard>
 */
class FlashCardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $practiceStatus = ['Not_answered', 'Correct', 'Incorrect'];
        $users = User::pluck('id')->toArray();
        return [
            'user_id' => $this->faker->randomElement($users),
            'question' => 'What company did you work for in '. $this->faker->date('Y_m_d').'?',
            'answer' => $this->faker->company(),
            'practice_status' => $practiceStatus[rand(0,2)]
        ];
    }
}
