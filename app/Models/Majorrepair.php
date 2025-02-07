<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Majorrepair extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'date',
        'location_name',
        'document',
        'document_uploaded_by',
        'ship_id',
        'hazmat_companies_id',
        'ship_staff_id'
    ];
}
