<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    public function prescriptions()
    {
        return $this->belongsToMany(Prescription::class, 'prescription_medicine')
            ->withPivot('dosage', 'duration')
            ->withTimestamps();
    }
}
