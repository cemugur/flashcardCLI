<?php declare(strict_types=1);

namespace App\Services\User;
use App\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class UserFindService {

    // All database methods in this class
    protected $userRepository;


    public function __construct(UserRepositoryInterface $userRepository) 
    {
        $this->userRepository=$userRepository;
    }

    /*
    * find user by using email address
    */
    public function findByMail(string $email): bool { 
        $user=$this->userRepository->findByMail($email);
        if($user) {
            Auth::login($user);
            return true;
        }
        return false;
    }

}