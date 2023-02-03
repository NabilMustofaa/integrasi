<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpectedAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'survey_question_id',
        'question_option_id',
        'answer',
        'created_by'
    ];

    
}
