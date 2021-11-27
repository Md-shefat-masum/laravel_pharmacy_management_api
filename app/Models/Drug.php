<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Drug extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = [
        'manufacture_date',
        'expiry_date',
        'quantity',
        'date_of_entry',
        'full_photo_url',

        'indication',
        'preparation',
        // 'dosage_and_administration',

        // 'category_name',
        // 'storage_location_name',
        // 'manufacturer_name',
    ];

    public static function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function getFullPhotoUrlAttribute()
    {
        return strlen($this->photoURL) > 0 ? $this->photoURL : url('/') . '/' . $this->photo;
    }

    public function getIndicationAttribute()
    {
        if (DrugInformation::where('drug_id', $this->id)->exists()) {
            return DrugInformation::where('drug_id', $this->id)->first()->indication;
        } else {
            return '';
        }
    }

    public function getDosageAndAdministrationAttribute()
    {
        if (DrugInformation::where('drug_id', $this->id)->exists()) {
            return DrugInformation::where('drug_id', $this->id)->first()->dosage_and_administration;
        } else {
            return '';
        }
    }

    public function getPreparationAttribute()
    {
        if (DrugInformation::where('drug_id', $this->id)->exists()) {
            return DrugInformation::where('drug_id', $this->id)->first()->preparation;
        } else {
            return '';
        }
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
