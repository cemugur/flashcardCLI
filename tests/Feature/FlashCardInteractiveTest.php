<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FlashCardInteractiveTest extends TestCase
{

    protected $username = 'test@studocu.com';
    const MENU = ['Create a flashcard', 'List all flashcards','Practice','Stats','Reset','Exit'];

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_interactive_menu_and_login_user()
    {
        $this->artisan('flashcard:interactive')
            ->expectsQuestion('Please enter your email address (Test email: test@studocu.com)', $this->username)
            ->expectsChoice(
                'Please select your action',
                'Exit',
                self::MENU
            );;
    }

    public function test_interactive_menu_and_send_wrong_email()
    {
        $this->artisan('flashcard:interactive')
            ->expectsQuestion('Please enter your email address (Test email: test@studocu.com)', 'das-asd')
            ->expectsQuestion('Email address not found in database. Please try again!', $this->username)
            ->expectsChoice(
                'Please select your action',
                'Exit',
                self::MENU
            );;
    }
}
