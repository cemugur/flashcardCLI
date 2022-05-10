<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\FlashCard;
use Symfony\Component\Console\Helper\TableSeparator;

class FlashCardStatsTest extends TestCase
{
    protected $username = 'test@studocu.com';
    const MENU = ['Create a flashcard', 'List all flashcards','Practice','Stats','Reset','Exit'];

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_not_answered_stats_of_flashcards()
    {
        $count = FlashCard::where('user_id', 1)->count();
        
        FlashCard::where('user_id', 1)->update(['practice_status'=>'Not_answered']);

        $this->artisan('flashcard:interactive')
            ->expectsQuestion('Please enter your email address (Test email: test@studocu.com)', $this->username)
            ->expectsChoice(
                'Please select your action',
                'Stats',
                self::MENU
            )
        ->expectsTable(['', 'Total'], 
        [
            ['Total Number of Questions', $count],
            new TableSeparator(),
            ['Answered Questions', '0%'],
            new TableSeparator(),
            ['Correct Questions ', '0%']
        ],'box')
        ->expectsQuestion('Please press Enter to continue or CTRL+C to exit', ' ')
        ->expectsChoice(
            'Please select your action',
            'Exit',
            self::MENU
        );

    }

    public function test_correct_stats_of_flashcards()
    {
        $count = FlashCard::where('user_id', 1)->count();
        
        FlashCard::where('user_id', 1)->update(['practice_status'=>'Correct']);

        $this->artisan('flashcard:interactive')
            ->expectsQuestion('Please enter your email address (Test email: test@studocu.com)', $this->username)
            ->expectsChoice(
                'Please select your action',
                'Stats',
                self::MENU
            )
        ->expectsTable(['', 'Total',], 
        [
            ['Total Number of Questions', $count],
            new TableSeparator(),
            ['Answered Questions', '100%'],
            new TableSeparator(),
            ['Correct Questions ', '100%'],
        ],'box')
        ->expectsQuestion('Please press Enter to continue or CTRL+C to exit', ' ')
        ->expectsChoice(
            'Please select your action',
            'Exit',
            self::MENU
        );

    }


    public function test_incorrect_stats_of_flashcards()
    {
        $count = FlashCard::where('user_id', 1)->count();
        
        FlashCard::where('user_id', 1)->update(['practice_status'=>'InCorrect']);

        $this->artisan('flashcard:interactive')
            ->expectsQuestion('Please enter your email address (Test email: test@studocu.com)', $this->username)
            ->expectsChoice(
                'Please select your action',
                'Stats',
                self::MENU
            )
        ->expectsTable(['', 'Total',], 
        [
            ['Total Number of Questions', $count],
            new TableSeparator(),
            ['Answered Questions', '100%'],
            new TableSeparator(),
            ['Correct Questions ', '0%'],
        ],'box')
        ->expectsQuestion('Please press Enter to continue or CTRL+C to exit', ' ')
        ->expectsChoice(
            'Please select your action',
            'Exit',
            self::MENU
        );

    }
}
