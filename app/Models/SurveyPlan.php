<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'survey_id',
        'store_id',
        'quality_assurance_team_id',
        'date',
    ];
}
