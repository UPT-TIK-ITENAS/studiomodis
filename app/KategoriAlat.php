<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KategoriAlat extends Model
{
    protected $guarded = [];
    protected $table = 'kategori_alat';

    public function alat()
    {
        return $this->hasMany('App\Alat');
    }
}
