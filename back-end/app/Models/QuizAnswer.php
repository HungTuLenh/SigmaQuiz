<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
class QuizAnswer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'quiz_question_id', 'description', 'corrert_answer'
    ];

    public function question()
    {
        return $this->belongsTo(QuizQuestion::class, 'quiz_question_id');
    }
}
