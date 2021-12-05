<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderPrescriptionImage extends Model
{
    use HasFactory;
    protected $appends = [
        'image_full_url'
    ];

    public function getImageFullUrlAttribute()
    {
        return url('/') . '/' . $this->image;
    }
}
