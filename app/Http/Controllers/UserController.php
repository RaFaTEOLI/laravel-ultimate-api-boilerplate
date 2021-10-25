<?php

namespace App\Http\Controllers;

use App\Http\HttpStatus;
use Illuminate\Http\Request;
use App\Repositories\User\UserRepository;
use App\Services\User\CreateUserService;
use App\Repositories\RolesRepository\RolesRepository;
use App\Http\Requests\User\UserRequest;
use App\Traits\ApiResponser;
use Exception;

class UserController extends Controller
{
    use ApiResponser;
    private $userRepository;

    public function __construct()
    {
        $this->middleware(["auth", "verified"]);
        $this->userRepository = new UserRepository();
    }

    public function index()
    {
        $users = $this->userRepository->all();

        return $this->success($users, HttpStatus::SUCCESS);
    }

    /**
     * @OA\Post(
     * path="/users",
     * summary="Create User",
     * description="Create user by name, email, password",
     * operationId="register",
     * tags={"User"},
     * security={ {"bearerAuth":{}} },
     * @OA\RequestBody(
     *    required=true,
     *    description="Send email, password",
     *    @OA\JsonContent(
     *       required={"email","password"},
     *       @OA\Property(property="email", type="string", format="email", example="user@email.com"),
     *       @OA\Property(property="password", type="string", format="password", example="PassWord12345"),
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
    public function store(UserRequest $request)
    {
        try {
            $input = $request->all();

            $createUserService = new CreateUserService();
            $user = $createUserService->execute($input);

            // Sends Email Verification
            $user->sendEmailVerificationNotification();

            return $this->success($user, HttpStatus::CREATED);
        } catch (Exception $e) {
            return $this->error(__("actions.error"), $e->getCode());
        }
    }

    /**
     * @OA\Get(
     * path="/users/{id}",
     * summary="Get User",
     * @OA\Parameter(
     *      name="id",
     *      description="User id",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer"
     *      )
     * ),
     * description="Show user data by id",
     * operationId="show",
     * tags={"User"},
     * security={ {"bearerAuth":{}} },
     * @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *      ref="#/components/schemas/UserRoles",
     *      ),
     *    ),
     *  ),
     * )
     */
    public function show($id)
    {
        $user = $this->userRepository->findById($id);
        $roles = (new RolesRepository())->findRolesNotInUser($id);

        return $this->success(["user" => $user, "roles" => $roles], HttpStatus::SUCCESS);
    }

    /**
     * @OA\Put(
     * path="/users/{id}",
     * summary="Update User",
     * description="Update User",
     * operationId="update",
     * security={ {"bearerAuth":{}} },
     * tags={"User"},
     * @OA\Parameter(
     *      name="id",
     *      description="User id",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer"
     *      )
     * ),
     *
     * @OA\RequestBody(
     *    required=true,
     *    description="Send name, email, photo to update user",
     *    @OA\JsonContent(
     *       @OA\Property(property="name", type="string", example="user@email.com"),
     *       @OA\Property(property="email", type="string", format="email", example="user@email.com"),
     *       @OA\Property(property="photo", type="string", example="/images/johndoe.png"),
     *    ),
     * ),
     * @OA\Response(
     *     response=204,
     *     description="No Content",
     *    ),
     *  ),
     * )
     */
    public function update($id, Request $request)
    {
        try {
            $input = $request->only(["name", "email"]);
            $this->userRepository->update($id, $input);

            return response()->noContent();
        } catch (Exception $e) {
            return $this->error(__("actions.error"), $e->getCode());
        }
    }

    /**
     * @OA\Delete(
     * path="/users/{id}",
     * summary="Delete User",
     * @OA\Parameter(
     *      name="id",
     *      description="User id",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer"
     *      )
     * ),
     * description="Delete user by id",
     * operationId="destroy",
     * tags={"User"},
     * security={ {"bearerAuth":{}} },
     * @OA\Response(
     *     response=204,
     *     description="No Content",
     *    ),
     *  ),
     * )
     */
    public function destroy($id)
    {
        try {
            $this->userRepository->delete($id);

            return response()->noContent();
        } catch (Exception $e) {
            return $this->error(__("actions.error"), $e->getCode());
        }
    }
}
