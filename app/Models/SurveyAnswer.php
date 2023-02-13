<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'survey_plan_id',
        'survey_question_id',
        'answer',
        'question_option_id',
        'created_by'
    ];

    public function plan()
    {
        return $this->belongsTo(SurveyPlan::class, 'survey_plan_id');
    }
}
