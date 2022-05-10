<?php

namespace App\Traits\Validations;

use Illuminate\Support\Facades\Validator;

trait FlashCardQuestionAnswerValidation {

    /**
     * @Illuminate\Support\Facades\Validator 
     * $name should be in format one word, or connect words with underscore like xxx_sss
     * @return error in array or bool
     */
    public function validator(?string $entry, string $name):bool|array 
    {
        $validator = Validator::make([
            $name   => $entry,
        ], [
            $name   => ['required','max:255'],
        ]);

        if ($validator->fails()) {
            return $validator->errors()->all();
        } 
        return true;
    }
}