<?php

namespace App\Interfaces;

interface UserRepositoryInterface 
{
    // Find User with email address
    public function findByMail(string $email): ?object; 

}