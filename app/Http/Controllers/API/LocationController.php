<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Regency;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function regencies(Request $request)
    {
        return Regency::all();
    }
}
