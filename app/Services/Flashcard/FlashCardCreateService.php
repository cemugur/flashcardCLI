<?php declare(strict_types=1);

namespace App\Services\Flashcard;
use App\Interfaces\FlashCardRepositoryInterface;
use App\Interfaces\UserAnswerRepositoryInterface;
use ErrorException;
use Exception;
use Illuminate\Support\Facades\Auth;

class FlashCardCreateService {

    
    protected $flashCardRepository;
    protected $userAnswerRepository;

    /**
     * Setting repositories which are connecting services to database layer
     */
    public function __construct(FlashCardRepositoryInterface $flashCardRepository, UserAnswerRepositoryInterface $userAnswerRepository) 
    {
        $this->flashCardRepository=$flashCardRepository;
        $this->userAnswerRepository=$userAnswerRepository;
    }

    /*
    * We are creating a FlashCard
    */
    public function create(string $question, string $answer):bool | string
    { 
        try{
            //Sanitize entries
            $question = htmlentities($question, ENT_QUOTES, 'UTF-8', false);
            $answer = htmlentities($answer, ENT_QUOTES, 'UTF-8', false);

            //Send entries to database create method
            $flashcard = $this->flashCardRepository->create($question, $answer);
            if(!$flashcard){
                throw new \Exception('An error occured. Flashcard did not created');
            }
            return true;

        } catch(Exception $e){
            return $e->getMessage();
        }
    }

}