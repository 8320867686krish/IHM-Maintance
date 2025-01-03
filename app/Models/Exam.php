<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;
    protected $fillable = [
        'ship_id',
        'ship_staff_id',
        'correct_ans',
        'wrong_ans',
        'total_ans'
    ];
}
