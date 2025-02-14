<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ship extends Model
{
    use HasFactory;
    protected $fillable = [
        'ship_initials',
        'ship_name',
        'is_unlock',
        'ship_type',
        'project_no',
        'imo_number',
        'client_company_id',
        'client_user_id',
        'user_id',
        'hazmat_companies_id',
        'ship_image',
        'call_sign',
        'port_of_registry',
        'vessel_class',
        'ihm_class',
        'flag_of_ship',
        'delivery_date',
        'building_details',
        'x_breadth_depth',
        'gross_tonnage',
        'vessel_previous_name',
        'ga_plan_pdf',
        'ga_plan_image',
        'initial_ihm_date',
        'survey_location',
        'prepared_by',
        'approved_by',
        'current_ihm_version',
        'ihm_version_updated_date'
    ];

    public function shipTeams()
    {
        return $this->hasMany(ShipTeams::class, 'ship_id', 'id');
    }
    public function client()
    {
        return $this->belongsTo(ClientCompany::class, 'client_company_id', 'id');
    }
    public function shipStaff()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function pOOrderItems()
    {
        return $this->hasMany(poOrderItem::class, 'ship_id', 'id');
    }
    public function decks()
    {
        return $this->hasMany(Deck::class);
    }
    public function pOOrderItemsHazmats()
    {
        return $this->hasMany(PoOrderItemsHazmats::class, 'ship_id', 'id');
    }
    public function exams(){
        return $this->hasMany(Exam::class, 'ship_id', 'id');

    }
    public function brifings(){
        return $this->hasMany(Brifing::class, 'ship_id', 'id');

    }
}
