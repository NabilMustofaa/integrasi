<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'question',
        'survey_id',
        'type',
        'created_by',
    ];

    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }

    public function options()
    {
        return $this->hasMany(QuestionOption::class, 'survey_question_id');
    }

    public function expected()
    {
        return $this->hasMany(ExpectedAnswer::class, 'survey_question_id');
    }

    public function answers()
    {
        return $this->hasMany(SurveyAnswer::class, 'survey_question_id');
    }



    
}
