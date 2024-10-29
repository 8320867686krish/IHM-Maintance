<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PoOrderItemsHazmats extends Model
{
    use HasFactory;
    protected $fillable = [
        'ship_id',
        'po_order_item_id',
        'hazmat_id ',
        'po_order_id',
        'hazmat_type',
     ];
}
