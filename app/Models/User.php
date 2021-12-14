<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $appends = [
        'photoURL',
        'displayName',
        'designation',
        'doctor_info',
    ];

    public function getPhotoURLAttribute($value)
    {
        return url('/') . '/' . $this->photo;
    }
    public function getDisplayNameAttribute()
    {
        return $this->user_name;
    }
    public function getDesignationAttribute()
    {
        if ($this->role_serial == 3) {
            return $this->doctor_designation()->get();
        } else {
            return [];
        }
    }
    public function getDoctorInfoAttribute()
    {
        if ($this->role_serial == 3) {
            return UserDoctorInformaion::where('doctor_id', $this->id)->exists() ?
                UserDoctorInformaion::where('doctor_id', $this->id)->first() : [];
        } else {
            return [];
        }
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    // protected $fillable = [
    //     'name',
    //     'email',
    //     'password',
    // ];

    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function user_role()
    {
        return $this->belongsTo(UserRole::class, 'role_serial', 'role_serial');
    }

    public function doctor_info()
    {
        return $this->belongsTo(UserDoctorInformaion::class);
    }

    public function doctor_designation()
    {
        return $this->belongsToMany(DoctorSpeciality::class);
    }
    public function doctor_assistance()
    {
        return $this->hasMany(DoctorAssistance::class,'doctor_id','id');
    }
}
