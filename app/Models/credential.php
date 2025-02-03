<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class credential extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'document',
        'hazmat_companies_id'
    ];
}
