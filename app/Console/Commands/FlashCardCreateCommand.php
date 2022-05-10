<?php
declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\Flashcard\FlashCardCreateService;
use App\Traits\FlashCardCommandLineValidationTrait;

class FlashCardCreateCommand extends Command
{

    use FlashCardCommandLineValidationTrait;

    protected $flashCardService;

    public function __construct(FlashCardCreateService $flashCardService) {
        $this->flashCardService=$flashCardService;
        parent::__construct();
    }


    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'flashcard:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new flashcard question and answer';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle():?int
    {
        //to run this command, firstly you need to login.
        $auth = $this->call('auth:check');
        if(!$auth){ return 0; }
        
        /**
         * Check if there is validation error then get the entry value
         * @App\Traits\FlashCardCommandLineValidationTrait->askAndValidate('name') method
         * 'name' string will print with error output if there is any error
        */
        $question = $this->askAndValidate('Question');
        $question = trim($question);
        
        $answer = $this->askAndValidate('Answer');
        $answer = trim($answer);

        /**
         * @App\Services\Flashcard\FlashCardCreateService all business logic here
         * Saving new question and answer to database
         */
        $result= $this->flashCardService->create($question,$answer);
        if($result !==true){
            $this->error($result);
            return 0;
        }
        $this->info("Flashcard successfully created! :)");
        
        return 1;
    }

}
