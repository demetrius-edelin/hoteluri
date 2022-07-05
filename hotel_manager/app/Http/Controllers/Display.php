<?php

namespace App\Http\Controllers;

use App\Data;
use App\Http\Classes\Camera;
use App\Http\Classes\Etaj;
use App\Http\Classes\Hotel;
use App\Http\Classes\Ocupant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Display extends Controller
{
    public function show()
    {
        return view('display', [
            'hotels' => Data::getStructure()
        ]);
    }
}
