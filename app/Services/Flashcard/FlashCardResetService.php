<?php declare(strict_types=1);

namespace App\Services\Flashcard;
use App\Interfaces\FlashCardRepositoryInterface;
use App\Interfaces\UserAnswerRepositoryInterface;
use Exception;

class FlashCardResetService {

    // All database methods in this class
    protected $flashCardRepository;
    protected $userAnswerRepository;

    public function __construct(FlashCardRepositoryInterface $flashCardRepository, UserAnswerRepositoryInterface $userAnswerRepository) 
    {
        $this->flashCardRepository=$flashCardRepository;
        $this->userAnswerRepository=$userAnswerRepository;
    }

    /**
     * Reset tables
     * delete all answers and update practice_status to not_answered
     */
    public function reset(): bool | string
    {
        try{
            $this->flashCardRepository->reset();
            $this->userAnswerRepository->reset();
            return true;
        } catch(Exception $e ){
            return $e->getMessage();
        }
    }
}