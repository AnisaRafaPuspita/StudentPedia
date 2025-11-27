<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Village extends Model
{
    protected $table = 'villages';

    protected $primaryKey = 'kode';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['kode', 'district_kode', 'nama'];

    public function district()
    {
        return $this->belongsTo(District::class, 'district_kode', 'kode');
    }
}
