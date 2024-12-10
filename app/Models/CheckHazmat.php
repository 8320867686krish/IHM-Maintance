<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckHazmat extends Model
{
    use HasFactory;
    protected $fillable = [
        'check_id',
        'hazmat_id',
        'application_of_paint',
        'name_of_paint',
        'location',
        'qty',
        'unit',
        'remarks',
        'ihm_part_table',
        'ship_id',
        'deck_id',
        'parts_where_used',
        'hazmat_type',
        'strike_document',
        'strike_remarks',
        'strike_date',
        'isStrike'
    ];
    public function getStrikeDocumentAttribute($value)
    {
        if (!$value) {
            return null; // Return null if the value is not available
        }
        return asset('uploads/shipsVscp/' . $this->ship_id . '/check' . "/".$value);
    }
    public function hazmat()
    {
        return $this->belongsTo(Hazmat::class);
    }
}
