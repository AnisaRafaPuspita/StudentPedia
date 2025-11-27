<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Regency extends Model
{
    protected $table = 'regencies';

    protected $primaryKey = 'kode';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['kode', 'province_kode', 'nama'];

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_kode', 'kode');
    }

    public function districts()
    {
        return $this->hasMany(District::class, 'regency_kode', 'kode');
    }
}
