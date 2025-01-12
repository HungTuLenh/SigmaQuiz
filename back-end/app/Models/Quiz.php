<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'description', 'image', 'difficulty'
    ];

    public function questions()
    {
        return $this->hasMany(QuizQuestion::class);
    }

    public function histories()
    {
        return $this->hasMany(History::class);
    }

    public function userAnswers()
    {
        return $this->hasMany(QuizUserAnswer::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_quizzes')
            ->withPivot('is_finish', 'time_start', 'time_end')
            ->withTimestamps();
    }
}
