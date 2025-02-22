<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DesignatedPerson extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'rank',
        'passport_number',
        'position',
        'sign_on_date',
        'sign_off_date',
        'ship_staff_id'
    ];

    public function designatedPersionShips()
    {
        return $this->hasMany(DesignatedPersionShip::class, 'designated_person_id');
    }
}
