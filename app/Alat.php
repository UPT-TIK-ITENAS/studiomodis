<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alat extends Model
{
    protected $guarded = [];
    protected $table = 'alat';

    public function kategori()
    {
        return $this->belongsTo('App\KategoriAlat', 'kategori_alat_id', 'id');
    }
}
