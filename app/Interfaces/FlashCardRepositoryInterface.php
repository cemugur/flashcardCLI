<?php

namespace App\Interfaces;

interface FlashCardRepositoryInterface 
{
    // Find flashcard with id
    public function find(int $id):object; 

    // Getting all flashcards information belongs to specific user
    public function getAll(); 

    // Create a new flashcard question and answer
    public function create(string $question, string $answer): int | object; 

    // Update flashcard practice status
    public function updatePracticeStatus(int $id, string $practiceStatus): int | object; 

    // Getting get All Practice Status
    public function getAllPracticeStatus():array | object; 

    // Uptade all flashcard practice statuses to Not_aswered
    public function reset(): bool | object; 
    
}