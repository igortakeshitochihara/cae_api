<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function ok($result)
    {
        return response()->json($result, 200);
    }

    public function okNumeric($result)
    {
        return response()->json($result, 200, [], JSON_NUMERIC_CHECK);
    }

    public function badRequest($result)
    {
        return response()->json(['message' => $result], 400);
    }

    public function redirect($url)
    {
        return redirect($url, 302);
    }
}
