<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deck extends Model
{
    use HasFactory;
    protected $fillable = [
        'ship_id', 
        'name',
        'image'
    ];
    public function checks()
    {
        return $this->hasMany(Check::class, 'deck_id', 'id');
    }
    public function getImageAttribute($value)
    {
        if (!$value) {
            return null; // Return null if the value is not available
        }
        return asset('uploads/shipsVscp/' . $this->ship_id  ."/". $value);
    }
}
