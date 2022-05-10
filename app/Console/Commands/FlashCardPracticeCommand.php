<?php
declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\Flashcard\FlashCardPracticeService;
use App\Traits\FlashCardCommandLineValidationTrait;
use App\Traits\FlashCardCreateTableTrait;

class FlashCardPracticeCommand extends Command
{

    use FlashCardCommandLineValidationTrait;
    use FlashCardCreateTableTrait;

    protected $flashCardService;

    public function __construct(FlashCardPracticeService $flashCardService) 
    {
        $this->flashCardService=$flashCardService;
        parent::__construct();
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'flashcard:practice';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ask a random flashcard question, get the answer and compare with original answer';

    /**
     * Execute the console command.
     *
     * @return int;
     */
    public function handle():int
    {
        //to run this command, firstly you need to login.
        $auth = $this->call('auth:check');
        if(!$auth){ return 0; }

        //getting all flashcard question with their status and percentage
        $flashCards = $this->flashCardService->getPractice();
        $questions = $flashCards[0];
        $correctAnswerPercentage = $flashCards[1].'% Correct Answers';
        
        //if not user has a flashcard question
        if(count($questions)===0){
            $this->newLine(2);
            $this->error('Empty database! Please create questions and answers.');
            $this->call('flashcard:create');
            return 0;
        }

        // @array question IDs in the database 
        $databaseTableIDs = $flashCards[2];
        // @array Question IDs in the table which is shown to the user, we are using this IDs for better UX
        $printedTableIDs = array_column($questions, 'id');   

        /**
         * print table and get all flash cards belongs to user
         * App\Traits\FlashCardCreateTableTrait createTable method
         */
        $headers = ['ID', 'Question','Practice Status']; 
        $this->createTable($headers, $questions, $correctAnswerPercentage);

        /*
        * Ask user to enter an ID of the questions
        * if user enter an invalid ID or selected a correctly answered question, ask again
        * Do while this process until user enter a valid ID, and update practice status then add answer to database
        */
        do{
            $isCorrectlyAnsweredQuestionID = true;
            // Do while user type an ID which is not belongs to not Correctly answered
            do {
                $selectedQuestionID = $this->ask('Please pick a Incorrect or Not answered question and type its ID (to exit from the practice just type "stop"');
                $selectedQuestionID = trim("$selectedQuestionID");

                //if typed "stop" to exit practice
                if(strtolower($selectedQuestionID) === 'stop'){
                    return 0;
                } elseif(!in_array($selectedQuestionID, $printedTableIDs)){
                    // user type invalid ID
                    $this->error('[ERROR] Value "'.$selectedQuestionID.'" is invalid ID or command');
                } else {
                    //if user select a question which answered correctly before, asking to choose another question
                    $isCorrectlyAnsweredQuestionID = $this->flashCardService->checkStatusIsCorrect(intval($selectedQuestionID), $questions);
                    
                    if($isCorrectlyAnsweredQuestionID){
                        $this->error('You already answered question "'.$selectedQuestionID.'" correctly, Please type another question ID');
                    }
                }
            } while($isCorrectlyAnsweredQuestionID);

        } while(!in_array($selectedQuestionID, $printedTableIDs));

        /**
         * Ask question answer, check is there any validation error and get the answer
         * In FlashCardCommandLineValidationTrait -> validator(entry, name) method
        */
        $answer = $this->askAndValidate('Answer');
        $answer = trim($answer);
        
        //compare user answer with the original answer
        $checkedResult = $this->flashCardService->checkAnswer($databaseTableIDs[$selectedQuestionID], $answer);
        if($checkedResult === 'Correct'){
            $this->printCorrectAnswer();
        } elseif($checkedResult === 'Incorrect') {
            $this->printInCorrectAnswer();
        } else {
            $this->error('An error occurred. Pls try again');
        }
        
        
        $this->ask('Please press Enter to continue or CTRL+C to exit');
        return 1;
    }

    // Print CORRECT answer to interface
    public function printCorrectAnswer():void 
    {
        $this->info('**************:)*******************');
        $this->info('************Good Job!**************');
        $this->info('*************CORRECT***************');
        $this->info('*************Answer****************');
        $this->info('***********************************');
    }

    // Print INCORRECT answer to interface
    public function printInCorrectAnswer():void
    {
        $this->error('**************:(******************');
        $this->error('***********INCORRECT**************');
        $this->error('********Please try again**********');
        $this->error('**********************************');
    }


}
