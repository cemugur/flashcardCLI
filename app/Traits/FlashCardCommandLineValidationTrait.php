<?php

namespace App\Traits;

use App\Traits\Validations\FlashCardQuestionAnswerValidation;

trait FlashCardCommandLineValidationTrait {

    use FlashCardQuestionAnswerValidation;

    /**
     * send a ask command to CLI and validate it
     */
    public function askAndValidate(string $name):string
    {
        //if there is validation error, it prints errors to CLI
        do{
            $entry = $this->ask('Please enter your '.$name);
            /**
             * Use laravel Validation class in the trait 
             * @App\Traits\Validations\FlashCardQuestionAnswerValidation validator method
             */
            $validationResult = $this->validator($entry, $name);
            if($validationResult !== true){
                foreach ($validationResult as $error) {
                    //command line print error method
                    parent::error($error); 
                }
            } 
        } while($validationResult !== true);

        return $entry;
    }
}