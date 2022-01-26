<?php

namespace App\Traits;

use App\Http\HttpStatus;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Api Responser Trait
|--------------------------------------------------------------------------
|
| This trait will be used for any response we sent to clients.
|
*/

trait ApiResponser
{
    /**
     * Return a success JSON response.
     *
     * @param  array|string  $data
     * @param  string  $message
     * @param  int|null  $code
     * @return \Illuminate\Http\JsonResponse
     */
    protected function success($data, int $code = 200)
    {
        if (is_string($data)) {
            return response()->json(["status" => "success", "message" => $data], $code);
        }
        return response()->json($data, $code);
    }

    /**
     * Return the user JSON response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function user()
    {
        return response()->json(Auth::user()->format(), HttpStatus::SUCCESS);
    }

    /**
     * Return a no content response.
     */
    protected function noContent()
    {
        return response()->noContent();
    }

    /**
     * Return an error JSON response.
     *
     * @param  string  $message
     * @param  int  $code
     * @param  array|string|null  $data
     * @return \Illuminate\Http\JsonResponse
     */
    protected function error(string $message = null, int $code, $data = null)
    {
        return response()->json([
            'status' => 'Error',
            'message' => $message,
            'data' => $data
        ], $code);
    }
}
