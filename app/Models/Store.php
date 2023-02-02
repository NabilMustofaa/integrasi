<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sales_team_id',
        'phone',
        'address',
        'longitude',
        'latitude',
        'created_by',
    ];
}
