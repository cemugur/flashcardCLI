<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlashCard extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'question',
        'answer',
        'practice_status'
    ];

    /**
     * Get the user that owns the flashcard.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the questions's answers
     */
    public function userAnswers()
    {
        return $this->hasMany(UserAnswer::class,'flash_card_id','id');
    }
}
