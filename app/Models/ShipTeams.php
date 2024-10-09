<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShipTeams extends Model
{
    use HasFactory;
    protected $fillable = [
        'ship_id', 
        'user_id',
        'hazmat_companies_id'
    ];
 
}
