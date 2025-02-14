<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class configration extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_company',
        'ship_staff',
        'hazmat_company',
        'training_material',
        'briefing_material',
        'sms_extract',
        'operation_manual'
    ];
}
