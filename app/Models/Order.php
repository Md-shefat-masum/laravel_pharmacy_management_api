<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $appends = [
        'formatted_date',
        'formatted_only_date',
    ];

    public function getFormattedDAteAttribute()
    {
        return $this->created_at->format('d-M-y h:s:i');
    }

    public function getFormattedOnlyDAteAttribute()
    {
        return $this->created_at->format('d/m/y');
    }

    public function shipping_address()
    {
        return $this->hasOne(OrderShippingAddress::class, 'order_id');
    }

    public function billing_address()
    {
        return $this->hasOne(OrderBillingAddress::class, 'order_id');
    }
    public function payment_details()
    {
        return $this->hasOne(OrderPayment::class, 'order_id');
    }

    public function order_details()
    {
        return $this->hasMany(OrderDetails::class, 'order_id', 'id');
    }
    public function order_image()
    {
        return $this->hasMany(OrderPrescriptionImage::class, 'order_id', 'id');
    }
}
