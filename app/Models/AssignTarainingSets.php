<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignTarainingSets extends Model
{
    use HasFactory;
    protected $fillable = [
        'training_sets_id', 
        'hazmat_companies_id'
    ];
    public function hazmatCompaniesName()
    {
        return $this->belongsTo(hazmatCompany::class,'hazmat_companies_id','id');

    }
}
