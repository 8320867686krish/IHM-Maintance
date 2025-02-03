<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DesignatedPersionShip extends Model
{
    use HasFactory;
    protected $fillable = [
        'ship_id',
        'designated_person_id'
    ];
    public function designatedPersonDetail(){
        return $this->belongsTo(DesignatedPerson::class,'designated_person_id','id');

    }
}
