<?php
declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

class FlashCardInteractiveCommand extends Command
{
    
    const MENU = [
        1 => 'Create a flashcard', 
        2 => 'List all flashcards',
        3 => 'Practice',
        4 => 'Stats',
        5 => 'Reset',
        6 => 'Exit'
    ];

    
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'flashcard:interactive';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show FlashCard Menu';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle():void
    {

        //$this->checkUser();
        $auth = $this->call('auth:check');
        if(!$auth){ return; }

        //Show the menu
        $choice = $this->choice(
            'Please select your action',
            self::MENU
        );
        
        //According to menu result, send new command
        switch ($choice) {
            case "Create a flashcard":

                $this->call('flashcard:create');

                break;

            case "List all flashcards":

                $this->call('flashcard:list');

                break;

            case "Practice":

                //practicing until user type "stop"
                do{
                    $result = $this->call('flashcard:practice');
                } 
                while($result==1);
                
                break;

            case "Stats":

                $this->call('flashcard:stats');

                break;

            case "Reset":

                $this->call('flashcard:reset');

                break;

            case "Exit":

                $this->info('Bye...');
                $this->newLine(2);
                Auth::logout();
                return;

            default:
                break;
        }
        $this->ask('Please press Enter to continue or CTRL+C to exit');
        $this->call('flashcard:interactive');
    }

}
