<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\PasswordValidationRules;
use App\Http\Requests\User\ResetPasswordRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Traits\ApiResponser;
use Exception;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Http\Controllers\NewPasswordController;

class ResetPasswordController extends Controller
{
    use ApiResponser;
    use PasswordValidationRules;
    /**
     * @OA\Post(
     * path="/forgot-password",
     * summary="Send reset password link",
     * description="Send reset password link to user",
     * operationId="send",
     * tags={"Reset Password"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Send email",
     *    @OA\JsonContent(
     *       @OA\Property(property="email", type="string", format="email", example="user@email.com"),
     *    ),
     * ),
     * @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Verification link sent!"),
     *      ),
     *    ),
     * )
     */
    public function send(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? $this->success(['status' => __($status)], 200)
            : $this->error(__($status), 401);
    }

    /**
     * @OA\Post(
     * path="/reset-password",
     * summary="Reset your password",
     * description="Send new password",
     * operationId="reset",
     * tags={"Reset Password"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Send email",
     *    @OA\JsonContent(
     *       @OA\Property(property="email", type="string", format="email", example="user@email.com"),
     *       @OA\Property(property="password", type="string", format="password", example="password"),
     *       @OA\Property(property="password_confirmation", type="string", format="password", example="password"),
     *    ),
     * ),
     * @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Your password has been reset!"),
     *      ),
     *    ),
     * )
     */
    public function reset(ResetPasswordRequest $request)
    {
        try {
            $response = (new NewPasswordController(Auth::guard()))->store($request);

            if (isset($response->toResponse($request)->original)) {
                return $this->success($response->toResponse($request)->original);
            }
            return $this->success($response->toResponse($request));
        } catch (Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }
}
