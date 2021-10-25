<?php

namespace App\Traits;

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
        return response()->json($data, $code);
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
