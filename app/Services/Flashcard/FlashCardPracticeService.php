<?php declare(strict_types=1);

namespace App\Services\Flashcard;
use App\Interfaces\FlashCardRepositoryInterface;
use App\Interfaces\UserAnswerRepositoryInterface;

class FlashCardPracticeService {

    // All database methods in this class
    protected $flashCardRepository;
    protected $userAnswerRepository;


    public function __construct(FlashCardRepositoryInterface $flashCardRepository, UserAnswerRepositoryInterface $userAnswerRepository) 
    {
        $this->flashCardRepository=$flashCardRepository;
        $this->userAnswerRepository=$userAnswerRepository;
    }


    /*
    *  We are getting all flashcards questions and practice status with IDs
    * @return array 
    * [[mock_id, questions, practice status], %correct/all, Database Ids]
    */
    public function getPractice(): array 
    { 

        $flashCards = $this->flashCardRepository->getAll();
        
        $totalFlashCards = count($flashCards);
        $percentage = 0;
        $correctAnswers = 0;
        $table = [];
        $i = 1;
        foreach($flashCards as $flashCard) {

            $practiceStatus = $flashCard['practice_status'];

            if($practiceStatus == 'Correct') {
                $correctAnswers++;
            }
            
            // we dont need this value in table
            unset($flashCard['answer']);
            
            $flashCardDatabaseIDs[$i] = $flashCard['id'];
            //mock id; give numeric, ascending id for better UX
            $flashCard['id'] = $i; 
            //table includes flashcard values
            $table[] = $flashCard;
            $i++;
        }
        if($totalFlashCards){
            $percentage = round($correctAnswers/$totalFlashCards*100);
        }
        return [$table, $percentage, $flashCardDatabaseIDs];
    }

    /*
    * Check practice status is it correct or not
    */
    public function checkStatusIsCorrect(int $id, array $flashCards):bool {

        $key = array_search($id, array_column($flashCards, 'id'));
        $status=$flashCards[$key]['practice_status'];
        if($status === 'Correct'){
            return true;
        } 
        return false;
    }

    /*
    * find flashcard and check user answer
    */
    public function checkAnswer(int $id, string $answer):bool | string 
    { 
        //get flashcard by id
        $flashCard = $this->flashCardRepository->find($id);

        //sanitize answer
        $answer = htmlentities($answer, ENT_QUOTES, 'UTF-8', false);
        //save to database
        $newAnswer = $this->userAnswerRepository->create($id, $answer);
        if(!$newAnswer){
            return false;
        }

        $practiceStatus = "Incorrect";

        if(strtolower($answer) === strtolower($flashCard->answer)){
            $practiceStatus = "Correct";
        }
        //According to comparison we are updating practice status
        if($flashCard->practice_status !== $practiceStatus){
            $this->flashCardRepository->updatePracticeStatus($id, $practiceStatus);
        }
        return $practiceStatus;
    }

}