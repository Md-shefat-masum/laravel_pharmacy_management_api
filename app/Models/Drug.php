<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Drug extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $appends = [
        'photoURL',
        'manufacture_date',
        'expiry_date',
        'quantity',
        'date_of_entry',
        // 'total_sale',
        // 'total_income',
        // 'category_name',
        // 'storage_location_name',
        // 'manufacturer_name',
    ];

    public function getPhotoURLAttribute()
    {
        return url('/') . '/' . $this->photo;
    }

    public function getManufactureDateAttribute()
    {
        if (DrugInformation::where('drug_id', $this->id)->exists()) {
            return DrugInformation::where('drug_id', $this->id)->first()->manufacturing_date;
        } else {
            return '';
        }
    }

    public function getExpiryDateAttribute()
    {
        if (DrugInformation::where('drug_id', $this->id)->exists()) {
            return DrugInformation::where('drug_id', $this->id)->first()->expiry_date;
        } else {
            return '';
        }
    }

    public function getQuantityAttribute()
    {
        if (DrugInformation::where('drug_id', $this->id)->exists()) {
            return DrugInformation::where('drug_id', $this->id)->first()->quantity;
        } else {
            return '';
        }
    }

    public function getDateOfEntryAttribute()
    {
        if (DrugInformation::where('drug_id', $this->id)->exists()) {
            return DrugInformation::where('drug_id', $this->id)->first()->date_of_entry;
        } else {
            return '';
        }
    }

    public function related_categories()
    {
        return $this->belongsToMany(DrugCategory::class)->withTimestamps();
    }

    public function related_drug_information()
    {
        return $this->belongsTo(DrugInformation::class)->withTimestamps();
    }

    public function related_drug_manufacturer()
    {
        return $this->belongsToMany(DrugManufacturer::class)->withTimestamps();
    }

    public function related_drug_storage()
    {
        return $this->belongsToMany(DrugStorage::class)->withTimestamps();
    }

    public function related_user_supplier()
    {
        return $this->belongsToMany(UserSupplier::class)->withTimestamps();
    }
}
