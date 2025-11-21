<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $fillable = [
        'regency_id',
        'name'
    ];

    public function regency()
    {
        return $this->belongsTo(Regency::class);
    }
}

