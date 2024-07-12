<?php
declare(strict_types=1);

namespace Vineeth\Controllers;

use JsonException;
use Teacher\GivenCode\Abstracts\AbstractController;
use Teacher\GivenCode\Exceptions\RequestException;
use Vineeth\Services\UserGroupService;

/**
 * Class UserGroupController
 */
class UserGroupController extends AbstractController
{
    private UserGroupService $userGroupService;
    
    public function __construct() {
        parent::__construct();
        $this->userGroupService = new UserGroupService();
    }
    
    /**
     * GET request handler to retrieve a user group record from the database.
     *
     * @throws RequestException
     */
    public function get(): void {
        if (empty($_REQUEST["groupId"])) {
            throw new RequestException("Bad request: required parameter [groupId] not found in the request.", 400);
        }
        
        if (!is_numeric($_REQUEST["groupId"])) {
            throw new RequestException(
                "Bad request: parameter [groupId] value [" . $_REQUEST["groupId"] . "] is not numeric.",
                400
            );
        }
        
        $groupId = (int)$_REQUEST["groupId"];
        $instance = $this->userGroupService->getUserGroupById($groupId);
        header("Content-Type: application/json;charset=UTF-8");
        echo $instance->toJson();
    }
    
    /**
     * POST request handler to create a new user group record in the database.
     *
     * @throws RequestException
     */
    public function post(): void {
        if (empty($_REQUEST["groupName"])) {
            throw new RequestException("Bad request: required parameter [groupName] not found in the request.", 400);
        }
        
        $instance = $this->userGroupService->createUserGroup(
            $_REQUEST["groupName"],
            $_REQUEST["groupDescription"] ?? null
        );
        header("Content-Type: application/json;charset=UTF-8");
        echo $instance->toJson();
    }
    
    /**
     * PUT request handler to update a user group record in the database.
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
        
        if (empty($_REQUEST["groupId"])) {
            throw new RequestException("Bad request: required parameter [groupId] not found in the request.", 400);
        }
        
        if (!is_numeric($_REQUEST["groupId"])) {
            throw new RequestException(
                "Bad request: parameter [groupId] value [" . $_REQUEST["groupId"] . "] is not numeric.",
                400
            );
        }
        
        if (empty($_REQUEST["groupName"])) {
            throw new RequestException("Bad request: required parameter [groupName] not found in the request.", 400);
        }
        
        $groupId = (int)$_REQUEST["groupId"];
        
        $instance = $this->userGroupService->updateUserGroup(
            $groupId,
            $_REQUEST["groupName"],
            $_REQUEST["groupDescription"] ?? null
        );
        header("Content-Type: application/json;charset=UTF-8");
        echo $instance->toJson();
    }
    
    /**
     * DELETE request handler to delete a user group record from the database.
     *
     * @throws RequestException
     */
    public function delete(): void {
        $request_contents = file_get_contents('php://input');
        parse_str($request_contents, $_REQUEST);
        
        if (empty($_REQUEST["groupId"])) {
            throw new RequestException("Bad request: required parameter [groupId] not found in the request.", 400);
        }
        
        if (!is_numeric($_REQUEST["groupId"])) {
            throw new RequestException(
                "Bad request: parameter [groupId] value [" . $_REQUEST["groupId"] . "] is not numeric.",
                400
            );
        }
        
        $groupId = (int)$_REQUEST["groupId"];
        
        $this->userGroupService->deleteUserGroupById($groupId);
        header("Content-Type: application/json;charset=UTF-8");
        http_response_code(204);
    }
}
