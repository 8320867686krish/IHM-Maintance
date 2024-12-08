<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Summary extends Model
{
    use HasFactory;
    protected $fillable = [
        'hazmat_companies_id',
        'version',
        'ship_id',
        'document',
        'title',
        'uploaded_by',
        'date'
      
    ];
    public function getDocumentAttribute($value)
    {
        return asset('uploads/shipsVscp/' . $this->ship_id . '/summary' . "/".$value);
    }
    protected $hidden = [
        'updated_at',
        'created_at',
    ];
}
