<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\FlashCard;
use Symfony\Component\Console\Helper\TableSeparator;

class FlashCardPracticeTest extends TestCase
{
    //use RefreshDatabase;

    protected $username = 'test@studocu.com';
    const MENU = ['Create a flashcard', 'List all flashcards','Practice','Stats','Reset','Exit'];

    /**
     * A basic feature test example.
     *
     * @return void
     */
    
    public function test_practice_with_correct_answer()
    {
        FlashCard::where('user_id', 1)->delete();
        

        $flashcard = FlashCard::create([
            'user_id' => 1,
            'question' => 'This is a Test Question',
            'answer' => 'This is a Test Answer',
            'practice_status' => 'Not_answered'
            ]
        );
     
        $this->artisan('flashcard:interactive')
            ->expectsQuestion('Please enter your email address (Test email: test@studocu.com)', $this->username)
            ->expectsChoice(
                'Please select your action',
                'Practice',
                self::MENU
            )
            ->expectsTable(['ID', 'Question', 'Practice Status'], 
            [
                ['1', 'This is a Test Question', 'Not_answered']
            ],'box')
            ->expectsOutput(' 0% Correct Answers')
            ->expectsQuestion('Please pick a Incorrect or Not answered question and type its ID (to exit from the practice just type "stop"', 1)
            ->expectsQuestion('Please enter your Answer', 'This is a Test Answer')
            ->expectsOutput('**************:)*******************')
            ->expectsOutput('************Good Job!**************')
            ->expectsOutput('*************CORRECT***************')
            ->expectsOutput('*************Answer****************')
            ->expectsOutput('***********************************')

            ->expectsQuestion('Please press Enter to continue or CTRL+C to exit', ' ')
            ->expectsTable(['ID', 'Question', 'Practice Status'], 
            [
                ['1', 'This is a Test Question', 'Correct']
            ],'box')
            ->expectsOutput(' 100% Correct Answers')
            ->expectsQuestion('Please pick a Incorrect or Not answered question and type its ID (to exit from the practice just type "stop"', 'stop')
            ->expectsQuestion('Please press Enter to continue or CTRL+C to exit', ' ')
            ->expectsChoice(
                'Please select your action',
                'Exit',
                self::MENU
            );
    }

    public function test_practice_with_wrong_answer()
    {
        FlashCard::where('user_id', 1)->delete();
        

        $flashcard = FlashCard::create([
            'user_id' => 1,
            'question' => 'This is a Test Question',
            'answer' => 'This is a Test Answer',
            'practice_status' => 'Not_answered'
            ]
        );
     
        $this->artisan('flashcard:interactive')
            ->expectsQuestion('Please enter your email address (Test email: test@studocu.com)', $this->username)
            ->expectsChoice(
                'Please select your action',
                'Practice',
                self::MENU
            )
            ->expectsTable(['ID', 'Question', 'Practice Status'], 
            [
                ['1', 'This is a Test Question', 'Not_answered']
            ],'box')
            ->expectsOutput(' 0% Correct Answers')
            ->expectsQuestion('Please pick a Incorrect or Not answered question and type its ID (to exit from the practice just type "stop"', 1)
            ->expectsQuestion('Please enter your Answer', 'This is not a Test Answer')

            ->expectsOutput('**************:(******************')
            ->expectsOutput('***********INCORRECT**************')
            ->expectsOutput('********Please try again**********')
            ->expectsOutput('**********************************')

            ->expectsQuestion('Please press Enter to continue or CTRL+C to exit', ' ')
            ->expectsTable(['ID', 'Question', 'Practice Status'], 
            [
                ['1', 'This is a Test Question', 'Incorrect']
            ],'box')
            ->expectsOutput(' 0% Correct Answers')
            ->expectsQuestion('Please pick a Incorrect or Not answered question and type its ID (to exit from the practice just type "stop"', 'stop')
            ->expectsQuestion('Please press Enter to continue or CTRL+C to exit', ' ')
            ->expectsChoice(
                'Please select your action',
                'Exit',
                self::MENU
            );
    }

    public function test_practice_enter_stop()
    {
        FlashCard::where('user_id', 1)->delete();
        

        $flashcard = FlashCard::create([
            'user_id' => 1,
            'question' => 'This is a Test Question',
            'answer' => 'This is a Test Answer',
            'practice_status' => 'Not_answered'
            ]
        );
     
        $this->artisan('flashcard:interactive')
            ->expectsQuestion('Please enter your email address (Test email: test@studocu.com)', $this->username)
            ->expectsChoice(
                'Please select your action',
                'Practice',
                self::MENU
            )
            ->expectsTable(['ID', 'Question', 'Practice Status'], 
            [
                ['1', 'This is a Test Question', 'Not_answered']
            ],'box')
            ->expectsOutput(' 0% Correct Answers')
            ->expectsQuestion('Please pick a Incorrect or Not answered question and type its ID (to exit from the practice just type "stop"', 'stop')
            ->expectsQuestion('Please press Enter to continue or CTRL+C to exit', ' ')
            ->expectsChoice(
                'Please select your action',
                'Exit',
                self::MENU
            );
           
    }

    public function test_practice_try_to_select_correctly_answered_question_id()
    {
        FlashCard::where('user_id', 1)->delete();
        

        $flashcard = FlashCard::create([
            'user_id' => 1,
            'question' => 'This is a Test Question',
            'answer' => 'This is a Test Answer',
            'practice_status' => 'Correct'
            ]
        );
     
        $this->artisan('flashcard:interactive')
            ->expectsQuestion('Please enter your email address (Test email: test@studocu.com)', $this->username)
            ->expectsChoice(
                'Please select your action',
                'Practice',
                self::MENU
            )
            ->expectsTable(['ID', 'Question', 'Practice Status'], 
            [
                ['1', 'This is a Test Question', 'Correct']
            ],'box')
            ->expectsOutput(' 100% Correct Answers')
            ->expectsQuestion('Please pick a Incorrect or Not answered question and type its ID (to exit from the practice just type "stop"', 1)
            ->expectsOutput('You already answered question "1" correctly, Please type another question ID')
            ->expectsQuestion('Please pick a Incorrect or Not answered question and type its ID (to exit from the practice just type "stop"', 'stop')
            ->expectsQuestion('Please press Enter to continue or CTRL+C to exit', ' ')
            ->expectsChoice(
                'Please select your action',
                'Exit',
                self::MENU
            );
    }


}
