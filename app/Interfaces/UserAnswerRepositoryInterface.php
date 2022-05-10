<?php

namespace App\Interfaces;

interface UserAnswerRepositoryInterface 
{
    // Create an answer
    public function create(int $flashCardID, string $answer);

    // Delete all saved answers which belongs to specific user
    public function reset(); 
}