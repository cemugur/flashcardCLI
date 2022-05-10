<?php declare(strict_types=1);

namespace App\Repositories;

use App\Models\FlashCard;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\FlashCardRepositoryInterface;

class FlashCardRepository implements FlashCardRepositoryInterface {

    protected $flashcard;

    public function __construct(FlashCard $flashcard)
    {
        $this->flashcard = $flashcard;
    }

    /*
    * find specific flashcard
    */
    public function find(int $id):object {
        $flashcard = Auth::user()->flashcards()->find($id);
        return $flashcard;
    }
    
    /*
    * Getting all flashcards
    */
    public function getAll():array 
    {
        $flashcard = Auth::user()->flashcards()->select('id', 'question','answer','practice_status')->get()->toArray();
        return  $flashcard;
    }

    /*
    * Create a new flashcard question and answer 
    */
    public function create(string $question, string $answer): int | object 
    {
        $createdFlashCard = Auth::user()->flashcards()->firstOrCreate(
            [ 'question' => $question],
            [ 'answer' => $answer ]
        );
        return $createdFlashCard;
    }

    /*
    * Update a specific user's flashcard's practice_status
    */
    public function updatePracticeStatus(int $id, string $practiceStatus): int | object
    {
        $updatedFlashCard = Auth::user()->flashcards()
        ->where('id', $id)
        ->update(
            [ 'practice_status' => $practiceStatus]
        );
        return $updatedFlashCard;
    }

    /*
    * Getting all flashcard's practice statuses
    * return array
    */
    public function getAllPracticeStatus():array | object {
        $flashcards = Auth::user()->flashcards()->pluck('practice_status')->all();
        return $flashcards;
    }

    /*
    * Update practice status to Not_answered //'Correct', 'Incorrect' status to => 'Not_answered'
    */
    public function reset():bool | object {
        $reset = Auth::user()->flashcards();
        $reset->update(['practice_status'=>'Not_answered']);
        return $reset;
    }
}