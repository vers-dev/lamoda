<?php

namespace App\Http\Controllers;

use Illuminate\Http\Resources\Json\JsonResource;

abstract class Controller
{
    protected function successResponse(array|JsonResource $data, $code = 200)
    {
        return response()->json($data, $code);
    }
}
