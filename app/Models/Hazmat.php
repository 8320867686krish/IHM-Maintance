<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hazmat extends Model
{
    use HasFactory;
    protected $fillable = ["name", "short_name", "table_type", "color",'short_name'];

    protected $hidden = ['created_at', 'updated_at'];
}