<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorPrescription extends Model
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
    public function investigations()
    {
        return $this->hasMany(DoctorPrescriptionInvestigation::class,'prescription_id','id');
    }
    public function medicines()
    {
        return $this->hasMany(DoctorPrescriptionMedicine::class,'prescription_id','id');
    }
}
