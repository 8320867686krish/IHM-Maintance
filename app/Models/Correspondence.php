<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Correspondence extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_company_id',
        'ship_id',
        'subject',
        'attachment',
        'content',
        'hazmat_companies_id',
        'user_id',
        'isRead'
    ];

    public function shipDetail(){
        return $this->belongsTo(Ship::class,'ship_id','id');
    }

    public function clientDetail(){
        return $this->belongsTo(ClientCompany::class,'client_company_id','id');
    }
    
    public function hmatCompanyDetail(){
        return $this->belongsTo(hazmatCompany::class,'hazmat_companies_id','id');
    }
}
