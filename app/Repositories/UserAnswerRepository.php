<?php declare(strict_types=1);

namespace App\Repositories;

use Illuminate\Support\Str;
use App\Models\UserAnswer;
use App\Models\FlashCard;
use App\Interfaces\UserAnswerRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Exception;

class UserAnswerRepository implements UserAnswerRepositoryInterface {

    protected $userAnswer;
    public function __construct(UserAnswer $userAnswer)
    {
        $this->userAnswer = $userAnswer;
    }

    /*
    * Save user answers to UserAnswers table
    */
    public function create(int $flashCardID, string $answer):bool | object
    {
        $newAnswer = $this->userAnswer->create([
            'flash_card_id' => $flashCardID,
            'answer' => $answer
        ]);
        return $newAnswer;
    }

    // Delete all answers
    public function reset(): bool | string 
    {
        try{
            $questions=Auth::user()->flashcards()->get();
            foreach($questions as $q){
                $q->userAnswers()->delete();
            }
            return true;
        }
        catch(Exception $e){
            return $e->getMessage(); 
        }
    }
}