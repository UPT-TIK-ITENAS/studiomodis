<?php

namespace App\Http\Controllers;

use App\Borrow;
use Illuminate\Http\Request;

class BorrowDetailCheck extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, $id)
    {
        $borrow = Borrow::with(['ruangan', 'alat'])->findOrFail($id);
        return $borrow;
    }
}
