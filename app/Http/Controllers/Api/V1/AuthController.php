<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function authenticate(Request $request)
    {
        return response()->json($request->all(),200);
    }

    public function register(Request $request)
    {
        
    }
}
