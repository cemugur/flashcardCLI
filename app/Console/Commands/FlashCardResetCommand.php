<?php
declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\Flashcard\FlashCardResetService;

class FlashCardResetCommand extends Command
{

    protected $flashCardService;

    /**
     * App\Services\Flashcard\FlashCardStatService all business logic here
    */
    public function __construct(FlashCardResetService $flashCardService) 
    {
        $this->flashCardService=$flashCardService;
        parent::__construct();
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'flashcard:reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command erase all practice progress and allow a fresh start.';

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

        //Creating progress bar for better UX
        $bar = $this->output->createProgressBar(10);
        $bar->start();
            $resetResponse = $this->flashCardService->reset();
            if($resetResponse !== true){
                $this->error('An error occurred. Pls try again!');
                return;
            }
            for ($i = 0; $i < 3; $i++) {
                sleep(1);
            }
        $bar->finish();

        $this->newLine(2);
        $this->line('Table reset successfully');
    }

}

