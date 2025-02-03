<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientCompany extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'manager_initials',
        'ship_owner_email',
        'ship_owner_name',
        'ship_owner_address',
        'ship_owner_phone',
        'contact_person_name',
        'contact_person_phone',
        'contact_person_designation',
        'tax_details',
        'created_by',
        'user_id',
        'hazmat_companies_id',
        'IMO_ship_owner_details',
        'owner_contact_person_email',
        'client_image',
        'accounting_team_email',
        'overall_incharge',
        'responsible_person',
        'training_requirement_overall_incharge',
        'crew_briefing_requiremet'

    ];
    public function hazmatCompaniesId()
    {
        return $this->belongsTo(hazmatCompany::class,'hazmat_companies_id','id');
    }

    public function userDetail(){
        return $this->belongsTo(User::class,'user_id','id');
    }
}
