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
        'position_left',
        'position_top',
        'initialsChekId',
        'ship_id',
        'deck_id',
        'close_image',
        'away_image',
    ];
 
    public function getCloseImageAttribute($value)
    {
        if (is_null($value)) {
            return null; // Return null if the value is null
        }
    
        return asset('uploads/shipsVscp/' . $this->ship_id . '/check' ."/". $value);
    }
    public function getAwayImageAttribute($value)
    {
        if (is_null($value)) {
            return null; // Return null if the value is null
        }
    
        return asset('uploads/shipsVscp/' . $this->ship_id . '/check' ."/". $value);
    }
    public function hazmats()
    {
        return $this->hasMany(CheckHazmat::class,'check_id', 'id');
    }
}
