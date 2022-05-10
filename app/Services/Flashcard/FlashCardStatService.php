<?php declare(strict_types=1);

namespace App\Services\Flashcard;
use App\Interfaces\FlashCardRepositoryInterface;

class FlashCardStatService {

    // All database methods in this class
    protected $flashCardRepository;

    public function __construct(FlashCardRepositoryInterface $flashCardRepository) 
    {
        $this->flashCardRepository=$flashCardRepository;
    }

    /*
    * The total amount of questions.
    *- % of questions that have an answer.
    *- % of questions that have a correct answer.
    */
    public function getStats():array { 
        
        $allPracticeStatus = $this->flashCardRepository->getAllPracticeStatus();
        $totalQuestions = count($allPracticeStatus);
        $totalAnsweredQuestions = $totalCorrectQuestions = 0;
        
        if($totalQuestions !== 0){
            $countValues = array_count_values($allPracticeStatus);
            $correct     = $countValues['Correct'] ?? 0; 
            $inCorrect   = $countValues['Incorrect'] ?? 0; 
            $totalAnsweredQuestions = round((($correct + $inCorrect) / $totalQuestions)*100);
            $totalCorrectQuestions  = round(($correct / $totalQuestions)*100);
        }
        
        return [
            ['Total Number of Questions', $totalQuestions], 
            ['Answered Questions', $totalAnsweredQuestions.'%'], 
            ['Correct Questions', $totalCorrectQuestions.'%' ]
        ];
    }

}