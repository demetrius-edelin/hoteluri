<?php

namespace App\Http\Controllers;

use App\Data;

class Display extends Controller
{
    public function show()
    {
        if (session('ziuaCurenta') == '') {
            session(['ziuaCurenta' => date('Y-m-d')]);
        }

        return view('display', [
            'hotels' => Data::getStructure(),
            'ziuaCurenta' => session('ziuaCurenta')
        ]);
    }
}
