<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'created_by',
        'survey_category_id',
    ];

    public function surveyCategory()
    {
        return $this->belongsTo(SurveyCategory::class);
    }

    public function surveyQuestions()
    {
        return $this->hasMany(SurveyQuestion::class, 'survey_id', 'id');
    }
}
