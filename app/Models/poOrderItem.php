<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class poOrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'ship_id',
        'description',
        'qty',
        'po_order_id',
        'unit',
        'impa_no',
        'part_no',
        'type_category',

    ];
    public function poOrderItemsHazmets()
    {
        return $this->hasMany(PoOrderItemsHazmats::class, 'po_order_item_id', 'id');
    }
    public function poOrder(){
        return $this->belongsTo(poOrder::class,'po_order_id','id');
    }
}
