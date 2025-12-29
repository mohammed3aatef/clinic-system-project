<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


class Patient extends Model
{
    protected $fillable = [
        'name',
        'age',
        'phone',
        'address',
        'gender',
        'user_id'
    ];

    protected static function booted()
    {
        static::creating(function ($patient) {
            if (Auth::check()) {
                $patient->user_id = Auth::id();
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }
}
