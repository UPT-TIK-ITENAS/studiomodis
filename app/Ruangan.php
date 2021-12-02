<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ruangan extends Model
{
    protected $guarded = [];
    protected $table = 'ruangan';

    public function borrow()
    {
        return $this->morphToMany(Borrow::class, 'borrowable');
    }
}
