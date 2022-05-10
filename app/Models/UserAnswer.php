<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'flash_card_id',
        'answer'
    ];
    
    /**
     * Get the question for the user answers.
     */
    public function question()
    {
        return $this->belongsTo(FlashCard::class);
    }
}
