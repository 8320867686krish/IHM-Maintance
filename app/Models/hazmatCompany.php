<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class hazmatCompany extends Model
{
    use HasFactory;
    protected $tabl = "hazmat_companies";
    protected $fillable = ['name','email','password','first_name','last_name','phone','logo'];
}
