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
        'isIHMUpdated',
        'arrived_date',
        'arrived_location',
        'ihm_location',
        'ihm_sublocation',
        'ihm_machinery_equipment',
        'ihm_parts',
        'ihm_qty',
        'ihm_unit',
        'ihm_remarks',
        'ihm_previous_qty',
        'ihm_previous_unit',
        'ihm_last_date',
        'ihm_date',
        'model_make_part_id',
        'ihm_table_type',
        'doc1',
        'doc2',
        'removal_quantity',
        'removal_unit',
        'removal_remarks',
        'isRecivedDoc',
        'recived_document_comment',
        'recived_document_date'
    ];
    protected $attributes = [
        'previous_hazmat_type' => null, // Add this as a transient attribute
    ];
    public function setIsRecivedDocAttribute($value)
    {

        $this->attributes['isRecivedDoc'] = $value == 'yes' ? 1 : ($value == 'no' ? 0 : $value);
    }
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
   
    public function getIsArrivedAttribute($value)
    {
        return $value === 1 ? 'yes' : 'no';
    }
    public function getIsRecivedDocAttribute($value)
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
    public function hazmat()
    {
        return $this->belongsTo(Hazmat::class);
    }
    protected static function boot()
    {
        parent::boot();

        // Attach an event listener for the "updating" event
        static::updating(function ($model) {
            $model->previous_hazmat_type = $model->getOriginal('hazmat_type'); // Store the old value
        });
    }

    public function makeModel(){
    return $this->belongsTo(MakeModel::class, 'model_make_part_id', 'id');
}
    public function poOrderItem(){
        return $this->belongsTo(poOrderItem::class);

    }
    
    public function emailHistory(){
        return $this->hasMany(emailHistory::class, 'po_order_item_hazmat_id', 'id');

    }
}
