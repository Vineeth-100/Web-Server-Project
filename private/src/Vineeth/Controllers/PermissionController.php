<?php
declare(strict_types=1);

namespace Vineeth\Controllers;

use JsonException;
use Teacher\GivenCode\Abstracts\AbstractController;
use Teacher\GivenCode\Exceptions\RequestException;
use Vineeth\services\PermissionService;

/**
 *
 */
class PermissionController extends AbstractController
{
    private PermissionService $permissionService;
    
    public function __construct() {
        parent::__construct();
        $this->permissionService = new PermissionService();
    }
    
    /**
     * GET request handler to retrieve a permission record from the database.
     *
     * @throws RequestException
     */
    public function get(): void  {
        if (empty($_REQUEST["permissionId"])) {
            throw new RequestException("Bad request: required parameter [permissionId] not found in the request.", 400);
        }
        
        if (!is_numeric($_REQUEST["permissionId"])) {
            throw new RequestException(
                "Bad request: parameter [permissionId] value [" . $_REQUEST["permissionId"] . "] is not numeric.",
                400
            );
        }
        
        $int_id = (int)$_REQUEST["permissionId"];
        $instance = $this->permissionService->getPermissionById($int_id);
        header("Content-Type: application/json;charset=UTF-8");
        echo $instance->toJSON();
    }
    
    /**
     * POST request handler to create a new permission record in the database.
     *
     * @throws RequestException
     */
    public function post(): void {
        if (empty($_REQUEST["permissionId"])) {
            throw new RequestException("Bad request: required parameter [userGroupId] not found in the request.", 400);
        }
        
        if (!is_numeric($_REQUEST["userGroupId"])) {
            throw new RequestException(
                "Bad request: parameter [userGroupId] value [" . $_REQUEST["userGroupId"] . "] is not numeric.",
                400
            );
        }
        
        if (empty($_REQUEST["permissionUnique"])) {
            throw new RequestException("Bad request: required parameter [permissionUnique] not found in the request.", 400);
        }
        if (empty($_REQUEST["permissionName"])) {
            throw new RequestException("Bad request: required parameter [permissionName] not found in the request.", 400);
        }
        
        
        $instance = $this->permissionService->createPermission($_REQUEST["permissionUnique"], $_REQUEST["permissionName"], $_REQUEST["description"]);
        header("Content-Type: application/json;charset=UTF-8");
        echo $instance->toJson();
    }
    
    /**
     * PUT request handler to update a permission record in the database.
     *
     * @throws RequestException
     */
    public function put(): void {
        $request_contents = file_get_contents('php://input');
        try {
            $_REQUEST = json_decode($request_contents, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $json_excep) {
            throw new RequestException("Invalid request contents format. Valid JSON is required.", 400, [], 400, $json_excep);
        }
        
        if (empty($_REQUEST["userGroupId"])) {
            throw new RequestException("Bad request: required parameter [userGroupId] not found in the request.", 400);
        }
        
        if (!is_numeric($_REQUEST["userGroupId"])) {
            throw new RequestException(
                "Bad request: parameter [userGroupId] value [" . $_REQUEST["userGroupId"] . "] is not numeric.",
                400
            );
        }
        
        if (empty($_REQUEST["permissionId"])) {
            throw new RequestException("Bad request: required parameter [userGroupId] not found in the request.", 400);
        }
        
        
        if (empty($_REQUEST["permissionUnique"])) {
            throw new RequestException("Bad request: required parameter [permissionUnique] not found in the request.", 400);
        }
        
        if (empty($_REQUEST["permissionName"])) {
            throw new RequestException("Bad request: required parameter [permissionName] not found in the request.", 400);
        }
        
        $permissionId = (int)$_REQUEST["permissionId"];
        
        $instance = $this->permissionService->updatePermission($permissionId, $_REQUEST["permissionUnique"], $_REQUEST["permissionName"], $_REQUEST["description"]);
        header("Content-Type: application/json;charset=UTF-8");
        echo $instance->toJson();
    }
    
    /**
     * DELETE request handler to delete a permission record in the database.
     *
     * @throws RequestException
     */
    public function delete(): void {
        $request_contents = file_get_contents('php://input');
        parse_str($request_contents, $_REQUEST);
        
        if (empty($_REQUEST["permissionId"])) {
            throw new RequestException("Bad request: required parameter [permissionId] not found in the request.", 400);
        }
        
        if (!is_numeric($_REQUEST["permissionId"])) {
            throw new RequestException(
                "Bad request: parameter [permissionId] value [" . $_REQUEST["permissionId"] . "] is not numeric.",
                400
            );
        }
        
        $permissionId = (int)$_REQUEST["permissionId"];
        
        $this->permissionService->deletePermissionById($permissionId);
        header("Content-Type: application/json;charset=UTF-8");
        http_response_code(204);
    }
}
