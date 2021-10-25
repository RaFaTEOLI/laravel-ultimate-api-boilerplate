<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\Verified;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\User;
use App\Traits\ApiResponser;

class VerifyEmailController extends Controller
{
    use ApiResponser;

    /**
     * @OA\Get(
     * path="/email/verify/{id}/{hash}",
     * summary="Verify email",
     * description="Verify user email",
     * operationId="invoke",
     * tags={"Verify"},
     * @OA\Parameter(
     *      name="id",
     *      description="User id",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer"
     *      )
     * ),
     * @OA\Parameter(
     *      name="hash",
     *      description="Hash",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="string"
     *      )
     * ),
     * @OA\Response(
     *     response=204,
     *     description="No Content",
     *    ),
     * )
     */
    public function __invoke(Request $request): RedirectResponse
    {
        $user = User::find($request->route('id'));

        if ($user->hasVerifiedEmail()) {
            return redirect(env('FRONT_URL') . '/email/verify/success');
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return redirect(env('FRONT_URL') . '/email/verify/success');
    }

    /**
     * @OA\Post(
     * path="/email/verify/resend",
     * summary="Resend email verification",
     * description="Resend email verification to user",
     * operationId="resend",
     * tags={"Verify"},
     * @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Verification link sent!"),
     *      ),
     *    ),
     * )
     */
    public function resend(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();
        return $this->success(['message' => 'Verification link sent!'], 200);
    }
}
