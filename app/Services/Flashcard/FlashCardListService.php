<?php declare(strict_types=1);

namespace App\Services\Flashcard;
use App\Interfaces\FlashCardRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class FlashCardListService {

    // All database methods in this class
    protected $flashCardRepository;

    public function __construct(FlashCardRepositoryInterface $flashCardRepository) 
    {
        $this->flashCardRepository=$flashCardRepository;
    }

    /*
    * We are getting all FlashCards for listing
    */
    public function getList():array
    { 
        //get all flashcards from database
        $flashCards = $this->flashCardRepository->getAll();
        $table = [];
        $i = 1;
        foreach($flashCards as $flashCard) {
            // we dont need this value
            unset($flashCard['practice_status']);
            //mock id for better UX
            $flashCard['id'] = $i;
            $table[] = $flashCard;
            $i++;
        }
        return $table;
    }

}