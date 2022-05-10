<?php
declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\Flashcard\FlashCardListService;
use App\Traits\FlashCardCreateTableTrait;

class FlashCardListCommand extends Command
{

    use FlashCardCreateTableTrait;

    protected $flashCardService;


    public function __construct(FlashCardListService $flashCardService) 
    {
        $this->flashCardService=$flashCardService;
        parent::__construct();
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'flashcard:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Lists all flashcards in a table';

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

        $headers=['ID', 'Question','Answer'];
        $flashCards= $this->flashCardService->getList();

        /**
         * App\Traits\FlashCardCreateTableTrait createTable method
         */
        $this->createTable($headers, $flashCards);
    }


}
