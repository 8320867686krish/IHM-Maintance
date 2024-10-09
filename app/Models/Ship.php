<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ship extends Model
{
    use HasFactory;
    protected $fillable = [
        'ship_initials', 
        'ship_name', 
        'ship_type',
        'project_no',
        'imo_number',
        'client_id',
        'client_user_id', 
        'user_id',
        'hazmat_companies_id'
    ];

   public function shipTeams(){
    return $this->hasMany(ShipTeams::class, 'ship_id', 'id');

   }
   public function client(){
    return $this->belongsTo(ClientCompany::class,'client_id', 'id');

   }
}
