<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brifing extends Model
{
    use HasFactory;
    protected $fillable = [
        'number_of_attendance', 
        'brifing_date',
        'brifing_document',
        'designated_people_id',
        'ship_id'
    ];
    public function DesignatedPersonDetail(){
        return $this->belongsTo(DesignatedPerson::class,'designated_people_id','id');
    }
}
