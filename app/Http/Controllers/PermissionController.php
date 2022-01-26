<?php

namespace App\Http\Controllers;

use App\Http\HttpStatus;
use App\Http\Requests\Permission\PermissionRequest;
use App\Repositories\PermissionRepository\PermissionRepository;
use App\Services\Permission\CreatePermissionService;
use App\Traits\ApiResponser;
use App\Traits\Pagination;
use Illuminate\Http\Request;
use Exception;

class PermissionController extends Controller
{
    use ApiResponser;
    use Pagination;
    private $permissionRepository;

    public function __construct()
    {
        $this->middleware(["auth", "verified"]);
        $this->permissionRepository = new PermissionRepository();
    }

    /**
     * @OA\Get(
     * path="/permissions",
     * summary="Get Permissions",
     * description="Get a list of permissions",
     * operationId="index",
     * tags={"Permission"},
     * security={ {"bearerAuth":{}} },
     * @OA\Parameter(
     *      name="offset",
     *      description="Offset for pagination",
     *      required=false,
     *      in="query",
     *      @OA\Schema(
     *          type="integer"
     *      )
     * ),
     * @OA\Parameter(
     *      name="limit",
     *      description="Limit of results for pagination",
     *      required=false,
     *      in="query",
     *      @OA\Schema(
     *          type="integer"
     *      )
     * ),
     * @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *         type="array",
     *         @OA\Items(ref="#/components/schemas/Permission")
     *      ),
     *    ),
     *  ),
     * )
     */
    public function index(Request $request)
    {
        $paginated = $this->paginate($request);
        $permissions = $this->permissionRepository->all($paginated["limit"], $paginated["offset"]);

        return $this->success($permissions, HttpStatus::SUCCESS);
    }

    /**
     * @OA\Post(
     * path="/permissions",
     * summary="Create Permission",
     * description="Create Permission by name, description",
     * operationId="store",
     * tags={"Permission"},
     * security={ {"bearerAuth":{}} },
     * @OA\RequestBody(
     *    required=true,
     *    description="Send name, value",
     *    @OA\JsonContent(
     *       required={"name","description"},
     *       @OA\Property(property="name", type="string", example="create-users"),
     *       @OA\Property(property="description", type="string", example="Create Users"),
     *       @OA\Property(property="create", type="string", example="on"),
     *       @OA\Property(property="update", type="string", example="on"),
     *       @OA\Property(property="read", type="string", example="on"),
     *       @OA\Property(property="delete", type="string", example="on"),
     *    ),
     * ),
     * @OA\Response(
     *     response=204,
     *     description="No Content",
     *    ),
     *  ),
     * )
     */
    public function store(PermissionRequest $request)
    {
        try {
            $input = $request->all();

            $createPermissionService = new CreatePermissionService();
            $createPermissionService->execute($input);

            return $this->success($input, HttpStatus::CREATED);
        } catch (Exception $e) {
            return $this->error(__("actions.error"), $e->getCode());
        }
    }

    /**
     * @OA\Get(
     * path="/permissions/{id}",
     * summary="Get Permission",
     * @OA\Parameter(
     *      name="id",
     *      description="Permission id",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer"
     *      )
     * ),
     * description="Show Permission by id",
     * operationId="show",
     * tags={"Permission"},
     * security={ {"bearerAuth":{}} },
     * @OA\Response(
     *     response=200,
     *     description="Success",
     *     @OA\JsonContent(
     *      ref="#/components/schemas/Permission",
     *      ),
     *    ),
     *  ),
     * )
     */
    public function show($id, Request $request)
    {
        $permission = $this->permissionRepository->findById($id);

        return $this->success($permission, HttpStatus::SUCCESS);
    }

    /**
     * @OA\Put(
     * path="/permissions/{id}",
     * summary="Update Permission",
     * description="Update Permission",
     * operationId="update",
     * security={ {"bearerAuth":{}} },
     * tags={"Permission"},
     * @OA\Parameter(
     *      name="id",
     *      description="Permission id",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer"
     *      )
     * ),
     *
     * @OA\RequestBody(
     *    required=true,
     *    description="Send name or display_name or description to update permission",
     *    @OA\JsonContent(
     *       @OA\Property(property="name", type="string", example="create-users"),
     *       @OA\Property(property="display_name", type="string", example="Create Users"),
     *       @OA\Property(property="description", type="string", example="Create Users"),
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
        $input = $request->only(["name", "display_name", "description"]);
        $this->permissionRepository->update($id, $input);

        return $this->noContent();
    }

    /**
     * @OA\Delete(
     * path="/permissions/{id}",
     * summary="Delete Permission",
     * @OA\Parameter(
     *      name="id",
     *      description="Permission id",
     *      required=true,
     *      in="path",
     *      @OA\Schema(
     *          type="integer"
     *      )
     * ),
     * description="Delete Permission by id",
     * operationId="destroy",
     * tags={"Permission"},
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
            $this->permissionRepository->delete($id);

            return $this->noContent();
        } catch (Exception $e) {
            return $this->error(__("actions.error"), $e->getCode());
        }
    }
}
