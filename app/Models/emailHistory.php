<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class emailHistory extends Model
{
    use HasFactory;
    protected $fillable = [
        'ship_id',
        'po_order_id',
        'po_order_item_id',
        'po_order_item_hazmat_id',
        'suppliear_email',
        'from_email',
        'company_email',
        'accounting_email',
        'shipstaff_email',
        'history_type'
    ];
}
