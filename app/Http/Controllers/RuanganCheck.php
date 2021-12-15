<?php

namespace App\Http\Controllers;

use App\Borrow;
use App\Http\Resources\RuanganCalendarResource;
use Illuminate\Http\Request;

class RuanganCheck extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        if ($request->ruangan != null) {
            $data = Borrow::with(['ruangan', 'user'])->whereDate('begin_date', '>=', $request->start)->whereDate('end_date', '<=', $request->end)->get();
            return RuanganCalendarResource::collection($data);
        } else {
            $data = Borrow::with(['ruangan', 'user'])->whereDate('begin_date', '>=', $request->start)->whereDate('end_date', '<=', $request->end)->whereHas(
                'ruangan',
                function ($query) use ($request) {
                    $query->where('id', $request->ruangan);
                }
            )->get();
            return RuanganCalendarResource::collection($data);
        }
    }
}
