<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\FlashCard;

class FlashCardResetTest extends TestCase
{

    protected $username = 'test@studocu.com';
    const MENU = ['Create a flashcard', 'List all flashcards','Practice','Stats','Reset','Exit'];

    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function test_reset_practice_status_to_not_answered()
    {
        FlashCard::where('user_id', 1)->delete();
        

        $flashcard = FlashCard::create(
            [
            'user_id' => 1,
            'question' => 'This is a Test Question',
            'answer' => 'This is a Test Answer',
            'practice_status' => 'Correct'
            ],
            [
                'user_id' => 1,
                'question' => 'This is a Test Question2',
                'answer' => 'This is a Test Answer2',
                'practice_status' => 'Incorrect'
            ]
        );
     
        $this->artisan('flashcard:interactive')
            ->expectsQuestion('Please enter your email address (Test email: test@studocu.com)', $this->username)
            ->expectsChoice(
                'Please select your action',
                'Reset',
                self::MENU
            )
            //->expectsOutput(' 10/10 [============================] 100%')
            ->expectsOutput('Table reset successfully')
            ->expectsQuestion('Please press Enter to continue or CTRL+C to exit', ' ')
            ->expectsChoice(
                'Please select your action',
                'Exit',
                self::MENU
            );
    }

}
