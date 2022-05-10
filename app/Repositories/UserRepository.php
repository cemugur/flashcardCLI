<?php declare(strict_types=1);

namespace App\Repositories;

use Illuminate\Support\Str;
use App\Models\User;
use App\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface {


    /*
    * Find User according to email address
    */
    public function findByMail(string $email): ?object
    {
        $user = User::where('email',$email)->first();
        return $user;
    }
    
}