<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QualityAssuranceTeam extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'phone',
        'created_by',
        'branch_id'
    ];
}
