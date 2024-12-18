<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingSets extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
    ];
    public function questions(){
        return $this->hasMany(QuestionSets::class, 'training_sets_id', 'id');
    }
    public function assignsethzmatCompany(){
        return $this->hasMany(AssignTarainingSets::class, 'training_sets_id', 'id');

    }
}
