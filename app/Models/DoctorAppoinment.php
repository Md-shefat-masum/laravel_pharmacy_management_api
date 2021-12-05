<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorAppoinment extends Model
{
    use HasFactory;

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }
    public function consumer()
    {
        return $this->belongsTo(User::class, 'consumer_id');
    }
}
