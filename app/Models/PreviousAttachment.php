<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreviousAttachment extends Model
{
    use HasFactory;
    protected $fillable = [
        'attachment_name',
        'date_from',
        'date_till',
        'maintained_by',
        'attachment',
        'ship_id'
    ];
}
