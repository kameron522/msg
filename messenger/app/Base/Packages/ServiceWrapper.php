<?php

namespace App\Base\Packages;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class ServiceWrapper
{
    public function __invoke(Closure $action): JsonResponse
    {
        try
        {
            DB::beginTransaction();
            $ActionResult = $action();
            DB::commit();
            return response()->json($ActionResult["action"], status: $ActionResult["status"]);
        }
        catch(\Throwable $th)
        {
            DB::rollBack();
            return response()->json($th->getMessage(), status: 500);
        }
    }
}
