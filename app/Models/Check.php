<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Check extends Model
{
    use HasFactory;
    protected $fillable = [
        'ship_id', 
        'deck_id',
        'type',
        'name',
        'equipment',
        'component',
        'position',
        'sub_position',
        'remarks',
        'position_left',
        'position_top',
        'recommendation',
        'initialsChekId',
        'ship_id',
        'deck_id',
    ];
    public function hazmats()
    {
        return $this->hasMany(CheckHazmat::class,'check_id', 'id');
    }
}
