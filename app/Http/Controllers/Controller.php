<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *    title="API",
 *    version="1.0.0",
 * )
 */
/**
 *
 *  @OA\Server(
 *      url="http://localhost/api/",
 *      description="API Server"
 * )
 */
/**
 * @OA\SecurityScheme(
 *      securityScheme="bearerAuth",
 *      description="Bearer {access_token}",
 *      in="header",
 *      name="bearerAuth",
 *      type="http",
 *      scheme="bearer",
 *      bearerFormat="JWT",
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
