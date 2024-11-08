<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PoOrderItemsHazmats extends Model
{
    use HasFactory;

    protected $fillable = [
        'ship_id',
        'po_order_item_id',
        'hazmat_id',
        'po_order_id',
        'hazmat_type',
        'isArrived',
        'isRemove',
        'service_supplier_name',
        'service_supplier_address',
        'removal_date',
        'removal_location',
        'attachment',
        'po_no',
        'isReturn',
        'isInstalled',
        'location',
        'date',
        'isIHMUpdated'
    ];
    public function setIsArrivedAttribute($value)
    {
      
        $this->attributes['isArrived'] = $value == 'yes' ? 1 : ($value == 'no' ? 0 : $value);

    }
    public function setIsReturnAttribute($value)
    {
        $this->attributes['isReturn'] = $value == 'yes' ? 1 : ($value == 'no' ? 0 : $value);
    }
    public function setIsInstalledAttribute($value)
    {
        $this->attributes['isInstalled'] = $value == 'yes' ? 1 : ($value == 'no' ? 0 : $value);
    }
    public function setIsIHMUpdatedAttribute($value)
    {
        $this->attributes['isIHMUpdated'] = $value == 'yes' ? 1 : ($value == 'no' ? 0 : $value);
    }
    public function setIsRemoveAttribute($value)
    {
        $this->attributes['isRemove'] = $value == 'yes' ? 1 : ($value == 'no' ? 0 : $value);
    }
    public function hazmat()
    {
        return $this->belongsTo(Hazmat::class);
    }
    public function getIsArrivedAttribute($value)
    {
        return $value === 1 ? 'yes' : 'no';
    }

    public function getIsReturnAttribute($value)
    {
        return $value == 1 ? 'yes' : 'no';
    }

    public function getIsInstalledAttribute($value)
    {
        return $value == 1 ? 'yes' : 'no';
    }

    public function getIsIHMUpdatedAttribute($value)
    {
        return $value == 1 ? 'yes' : 'no';
    }

    public function getIsRemoveAttribute($value)
    {
        return $value == 1 ? 'yes' : 'no';
    }
}
