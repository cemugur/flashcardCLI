<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FlashCardCreateTest extends TestCase
{
    //use RefreshDatabase;

    protected $username = 'test@studocu.com';
    const MENU = ['Create a flashcard', 'List all flashcards','Practice','Stats','Reset','Exit'];

    /**
     * A basic feature test example.
     *
     * @return void
     */
 
    public function test_create_new_flashcard_question_and_answer()
    {
        $this->artisan('flashcard:interactive')
            ->expectsQuestion('Please enter your email address (Test email: test@studocu.com)', $this->username)
            ->expectsChoice(
                'Please select your action',
                'Create a flashcard',
                self::MENU
            )
            ->expectsQuestion('Please enter your Question', 'This is Test Question')
            ->expectsQuestion('Please enter your Answer', 'This is Test Answer')
            ->expectsOutput('Flashcard successfully created! :)') 
            ->expectsQuestion('Please press Enter to continue or CTRL+C to exit', ' ')
            ->expectsChoice(
                'Please select your action',
                'Exit',
                self::MENU
            );
    }

    public function test_create_new_flashcard_send_empty_question_and_answer()
    {
        $this->artisan('flashcard:interactive')
            ->expectsQuestion('Please enter your email address (Test email: test@studocu.com)', $this->username)
            ->expectsChoice(
                'Please select your action',
                'Create a flashcard',
                self::MENU
            )
            ->expectsQuestion('Please enter your Question', '')
            ->expectsOutput('The question field is required.')
            ->expectsQuestion('Please enter your Question', 'This is Test Question')
            ->expectsQuestion('Please enter your Answer', '')
            ->expectsOutput('The answer field is required.')
            ->expectsQuestion('Please enter your Answer', 'This is Test Answer')
            ->expectsOutput('Flashcard successfully created! :)') 
            ->expectsQuestion('Please press Enter to continue or CTRL+C to exit', ' ')
            ->expectsChoice(
                'Please select your action',
                'Exit',
                self::MENU
            );
    }

    public function test_create_new_flashcard_question_send_more_than_255_character_question_and_answer()
    {
        $this->artisan('flashcard:interactive')
            ->expectsQuestion('Please enter your email address (Test email: test@studocu.com)', $this->username)
            ->expectsChoice(
                'Please select your action',
                'Create a flashcard',
                self::MENU
            )
            ->expectsQuestion('Please enter your Question', 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Lorem, ipsum dolor sit amet consectetur adipisicing elit. Natus quaerat aut, perferendis quasi ad nulla sunt minima placeat incidunt, consequatur cum. Minima rem aspernatur soluta officiis totam ipsum eum. Eveniet?')
            ->expectsOutput('The question must not be greater than 255 characters.')
            ->expectsQuestion('Please enter your Question', 'This is Test Question')
            ->expectsQuestion('Please enter your Answer', 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Lorem, ipsum dolor sit amet consectetur adipisicing elit. Natus quaerat aut, perferendis quasi ad nulla sunt minima placeat incidunt, consequatur cum. Minima rem aspernatur soluta officiis totam ipsum eum. Eveniet?')
            ->expectsOutput('The answer must not be greater than 255 characters.')
            ->expectsQuestion('Please enter your Answer', 'This is Test Answer')
            ->expectsOutput('Flashcard successfully created! :)') 
            ->expectsQuestion('Please press Enter to continue or CTRL+C to exit', ' ')
            ->expectsChoice(
                'Please select your action',
                'Exit',
                self::MENU
            );
    }
}
