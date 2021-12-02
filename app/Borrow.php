<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Borrow extends Model
{
    protected $guarded = [];
    protected $table = 'borrows';

    public function alat()
    {
        return $this->morphedByMany(Alat::class, 'borrowable');
    }

    public function ruangan()
    {
        return $this->morphedByMany(Ruangan::class, 'borrowable');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function scopeCheckAvailability(Builder $query, $id_ruangan, $begin_date, $end_date)
    {
        return $query->whereHas(
            'ruangan',
            function ($query) use ($id_ruangan) {
                $query->where('id', $id_ruangan);
            }
        )->whereDate('end_date', '>=', $begin_date)->whereDate('begin_date', '<=', $end_date);
    }
}
