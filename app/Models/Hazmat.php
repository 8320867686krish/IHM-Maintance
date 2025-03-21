<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hazmat extends Model
{
    use HasFactory;
    protected $fillable = ["name", "short_name", "table_type", "color", 'short_name'];

    protected $hidden = ['created_at', 'updated_at'];
    public function equipment()
    {
        return $this->hasMany(MakeModel::class);
    }
    public function poOrderItemsHazmats()
    {
        return $this->hasMany(PoOrderItemsHazmats::class, 'hazmat_id');
    }
    public function checkHazmats()
    {
        return $this->hasMany(CheckHazmat::class, 'hazmat_id');
    }
}
