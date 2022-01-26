<?php

namespace App\Http\Controllers;

use App\Exceptions\UserWrongCredentials;
use App\Traits\ApiResponser;
use App\Http\Controllers\Controller;
use App\Http\Requests\Authentication\SignInRequest;
use App\Http\Requests\Authentication\SignUpRequest;
use App\Services\Authentication\SignInUserService;
use App\Services\Authentication\SignUpUserService;
use Exception;

class AuthController extends Controller
{
    use ApiResponser;

    /**
     * @OA\Post(
     * path="/auth/register",
     * summary="Sign up",
     * description="Sign up by name, email, password",
     * operationId="register",
     * tags={"Authentication"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Send user name, email, password and hash to sign up",
     *    @OA\JsonContent(
     *       required={"name", "email", "password", "password_confirmation"},
     *       @OA\Property(property="name", type="string", example="user"),
     *       @OA\Property(property="email", type="string", format="email", example="user@email.com"),
     *       @OA\Property(property="password", type="string", format="password", example="PassWord12345"),
     *       @OA\Property(property="password_confirmation", type="string", format="password", example="PassWord12345"),
     *    ),
     * ),
     * @OA\Response(
     *     response=201,
     *     description="Created",
     *     @OA\JsonContent(
     *      ref="#/components/schemas/UserRoles",
     *      ),
     *    ),
     *  ),
     * )
     */
    public function register(SignUpRequest $request)
    {
        try {
            $user = (new SignUpUserService())->execute($request->only(['name', 'email', 'password']));

            $user->sendEmailVerificationNotification();

            return $this->success([
                'user' => $user->format(),
                'token' => $user->createToken('API Token')->plainTextToken
            ]);
        } catch (Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @OA\Post(
     * path="/auth/login",
     * summary="Sign in",
     * description="Login by email, password",
     * operationId="login",
     * tags={"Authentication"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"email","password"},
     *       @OA\Property(property="email", type="string", format="email", example="user@email.com"),
     *       @OA\Property(property="password", type="string", format="password", example="PassWord12345"),
     *    ),
     * ),
     * @OA\Response(
     *    response=422,
     *    description="Wrong credentials response",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Sorry, wrong email address or password. Please try again")
     *        )
     *     ),
     * @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(property="access_token", type="string", format="access_token", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3Q6ODAwMFwvYXBpXC9sb2dpbiIsImlhdCI6MTYyNjgyMzQ1OCwiZXhwIjoxNjI2ODI3MDU4LCJuYmYiOjE2MjY4MjM0NTgsImp0aSI6IkZmdWVSa21DRDVKbGJiZTUiLCJzdWIiOjEsInBydiI6IjIzd4rdsffdYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.IRcT8xxb8XqMmRCMMjEO_WZF764k6VV-gBDCXtQLBiU"),
     *       @OA\Property(property="token_type", type="string", format="string", example="bearer"),
     *       @OA\Property(property="expires_in", type="integer", format="string", example=3600),
     *       @OA\Property(property="user", type="object", ref="#/components/schemas/User"),
     *    ),
     *  ),
     * )
     *
     */
    public function login(SignInRequest $request)
    {
        try {
            (new SignInUserService())->execute($request->only(['email', 'password']));

            return $this->success([
                'user' => auth()->user()->format(),
                'token' => auth()->user()->createToken('API Token')->plainTextToken
            ]);
        } catch (UserWrongCredentials $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @OA\Post(
     * path="/auth/logout",
     * summary="Log out",
     * description="Log out from user",
     * operationId="logout",
     * tags={"Authentication"},
     * security={ {"bearerAuth":{}} },
     * @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *       @OA\Property(property="message", type="string", format="string", example="Tokens Revoked"),
     *    ),
     *  ),
     * )
     *
     */
    public function logout()
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => __('generic.tokensRevoked')
        ];
    }
}
