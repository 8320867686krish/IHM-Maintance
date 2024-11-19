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
}
