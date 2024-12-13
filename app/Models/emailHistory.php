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
        'start_date',
        'is_sent_email',
        'suppliear_email',
        'company_email',
        'accounting_email',
    ];
}
