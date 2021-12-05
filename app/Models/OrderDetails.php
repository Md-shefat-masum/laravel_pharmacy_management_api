<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function drug_details()
    {
        return $this->belongsTo(Drug::class, 'product_id', 'id');
    }
}
