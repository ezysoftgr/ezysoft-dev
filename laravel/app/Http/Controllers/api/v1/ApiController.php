<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class ApiController extends Controller
{


    public function check($api)
    {
        $user = User::where('api_key', $api)->first();

        if ($user){
            return response()->json([
                'status' => 200
            ]);
        }

        return response()->json([
            'status' => 401
        ]);

    }

}
