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
        'request_number',
        'vessel_no',
        'machinery',
        'make_model',
        'supplier_name',
        'address',
        'contact_person',
        'phone',
        'email',
    ];

    public function poOrderItems(){
        return $this->hasMany(poOrderItem::class, 'po_order_id', 'id');
    
       }
}


