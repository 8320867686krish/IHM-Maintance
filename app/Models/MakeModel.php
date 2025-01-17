<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MakeModel extends Model
{
    use HasFactory;
    protected $fillable = [
        "hazmat_id", 
        "equipment", 
        "model", 
        "make", 
        "manufacturer", 
        "part", 
        "document1", 
        "document2",
        "md_no",
        "sdoc_no",
        "hazmat_companies_id",
        "other_information",
        "md_date",
        "sdoc_date",
        "issuer_name",
        "sdoc_objects",
        "coumpany_name",
        "division_name",
        "address",
        "contact_person",
        "telephone_number",
        "fax_number",
        "email_address",
        "sdoc_id_no"
    ];

    protected $hidden = ['created_at', 'updated_at'];
    public function hazmat()
    {
        return $this->belongsTo(Hazmat::class);
    }
    public function getDocument1Attribute($value)
    {
        return [
            'name' => $value,
            'path' => env('ASSET_URL') . "/images/modelDocument/{$value}",
        ];
    }

    public function getDocument2Attribute($value)
    {
        return [
            'name' => $value,
            'path' => env('ASSET_URL') . "/images/modelDocument/{$value}",
        ];
    }


}
