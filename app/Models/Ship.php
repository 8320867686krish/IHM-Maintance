<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ship extends Model
{
    use HasFactory;
    protected $fillable = [
        'ship_initials', 
        'ship_name', 
        'ship_type',
        'ihm_table',
        'project_no',
        'imo_number',
        'client_id',
        'client_user_id', 
        'user_id',
        'hazmat_companies_id'
    ];

}
