<?php

namespace App\Http\Controllers;

use App\Http\HttpStatus;
use Exception;
use App\Services\RolePermission\UpdateRolePermissionService;
use App\Services\RolePermission\RemoveRolePermissionService;
use App\Http\Requests\RolePermission\RolePermissionRequest;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Validator;

class RolesPermissionController extends Controller
{
    use ApiResponser;

    public function store($roleId, $permissionId)
    {
        try {
            $validator = Validator::make(
                ["role_id" => $roleId, "permission_id" => $permissionId],
                RolePermissionRequest::rules($roleId)
            );

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator->errors());
            }

            $updateRolePermissionService = new UpdateRolePermissionService();
            $updateRolePermissionService->execute(["roleId" => $roleId, "permissionId" => $permissionId]);

            return $this->success(["id" => $roleId], HttpStatus::SUCCESS);
        } catch (Exception $e) {
            return $this->error(__("actions.error"), $e->getCode());
        }
    }

    public function destroy($roleId, $permissionId)
    {
        try {
            $validator = Validator::make(
                ["role_id" => $roleId, "permission_id" => $permissionId],
                RolePermissionRequest::deleteRules()
            );

            if ($validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($validator->errors());
            }

            $removeRolePermissionService = new RemoveRolePermissionService();
            $removeRolePermissionService->execute(["roleId" => $roleId, "permissionId" => $permissionId]);

            return $this->success(["id" => $roleId], HttpStatus::SUCCESS);
        } catch (Exception $e) {
            return $this->error(__("actions.error"), $e->getCode());
        }
    }
}
