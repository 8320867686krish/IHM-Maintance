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
        'hazmat_companies_id',
        'ship_image',
        'call_sign',
        'port_of_registry',
        'vessel_class',
        'ihm_class',
        'flag_of_ship',
        'delivery_date',
        'building_details',
        'x_breadth_depth',
        'gross_tonnage',
        'vessel_previous_name'
    ];

   public function shipTeams(){
    return $this->hasMany(ShipTeams::class, 'ship_id', 'id');

   }
   public function client(){
    return $this->belongsTo(ClientCompany::class,'client_id', 'id');

   }
   public function pOOrderItems(){
    return $this->hasMany(poOrderItem::class, 'ship_id', 'id');

   }
}
