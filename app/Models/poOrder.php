<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class poOrder extends Model
{
    use HasFactory;


    protected $fillable = [
        'ship_id',
        'po_no',
        'po_date',
        'vessel_name',
        'machinery',
        'make_model',
        'supplier_name',
        'address',
        'contact_person',
        'phone',
        'email',
        'delivery_location',
        'onboard_reciving_date',
        'isRecivedDoc',
        'recived_document_comment',
        'recived_document_date'
    ];
    public function getIsRecivedDocAttribute($value)
    {
        return $value === 1 ? 'yes' : 'no';
    }
    public function setIsRecivedDocAttribute($value)
    {

        $this->attributes['isRecivedDoc'] = $value == 'yes' ? 1 : ($value == 'no' ? 0 : $value);
    }
    public function poOrderItems()
    {
        return $this->hasMany(poOrderItem::class, 'po_order_id', 'id');
    }
    public function emailHistory(){
        return $this->hasMany(emailHistory::class, 'po_order_id', 'id');
    }
}
