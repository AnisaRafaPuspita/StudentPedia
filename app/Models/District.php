<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $table = 'districts';

    protected $primaryKey = 'kode';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['kode', 'regency_kode', 'nama'];

    public function regency()
    {
        return $this->belongsTo(Regency::class, 'regency_kode', 'kode');
    }

    public function villages()
    {
        return $this->hasMany(Village::class, 'district_kode', 'kode');
    }
}
