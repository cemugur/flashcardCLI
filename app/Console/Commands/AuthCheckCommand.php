<?php
declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use App\Services\User\UserFindService;

class AuthCheckCommand extends Command
{

    protected $userService;

    public function __construct(UserFindService $user) 
    {
        $this->user=$user;
        parent::__construct();
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auth:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command checks user loginned or not. If not loginned, it asks mail address and then login.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle():bool
    {
        if(!Auth::check()){
            // Getting email address to assign user_id to questions. 
            $email=$this->ask('Please enter your email address (Test email: test@example.com)');
            do{
                $isUser=$this->user->findByMail($email);
                if(!$isUser){
                    $email=$this->ask('Email address not found in database. Please try again!');
                }
            } while(!$isUser);
        }
        return true;

    }
}
