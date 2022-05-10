<?php
declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\Flashcard\FlashCardStatService;
use App\Traits\FlashCardCreateTableTrait;

class FlashCardStatCommand extends Command
{

    use FlashCardCreateTableTrait;

    protected $flashCardService;

    /**
     * App\Services\Flashcard\FlashCardStatService all business logic here
     */
    public function __construct(FlashCardStatService $flashCardService) 
    {
        $this->flashCardService=$flashCardService;
        parent::__construct();
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'flashcard:stats';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '
        Display the following stats:
        - The total amount of questions.
        - % of questions that have an answer.
        - % of questions that have a correct answer.';
    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle():void
    {
        //to run this command, firstly you need to login.
        $auth = $this->call('auth:check');
        if(!$auth){ return; }

        /**
         * App\Traits\FlashCardCreateTableTrait createTable method
         */
        $headers = ['', 'Total'];
        $stats = $this->flashCardService->getStats();
        $this->createTable($headers, $stats);
    }

}
