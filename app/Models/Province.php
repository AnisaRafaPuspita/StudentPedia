<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $table = 'provinces';

    protected $primaryKey = 'kode';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['kode', 'nama'];

    public function regencies()
    {
        return $this->hasMany(Regency::class, 'province_kode', 'kode');
    }
}
