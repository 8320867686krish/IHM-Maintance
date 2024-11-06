<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class poOrder extends Model
{
    use HasFactory;
  

    protected $fillable = [
        'ship_id',
        'po_no',
        'po_date',
        'vessel_name',
        'machinery',
        'make_model',
        'supplier_name',
        'address',
        'contact_person',
        'phone',
        'email',
        'delivery_location',
        'onboard_reciving_date',
    ];

    public function poOrderItems(){
        return $this->hasMany(poOrderItem::class, 'po_order_id', 'id');
    
       }
}


