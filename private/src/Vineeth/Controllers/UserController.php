<?php
declare(strict_types=1);

namespace Vineeth\Controllers;

use JsonException;
use Teacher\GivenCode\Abstracts\AbstractController;
use Teacher\GivenCode\Exceptions\RequestException;
use Vineeth\Services\UserService;

/**
 * Class UserController
 */
class UserController extends AbstractController {
    private UserService $userService;
    
    public function __construct() {
        parent::__construct();
        $this->userService = new UserService();
    }
    
    /**
     * GET request handler to retrieve a user record from the database.
     *
     * @throws RequestException
     */
    public function get(): void {
        if (empty($_REQUEST["userId"])) {
            throw new RequestException("Bad request: required parameter [userId] not found in the request.", 400);
        }
        
        if (!is_numeric($_REQUEST["userId"])) {
            throw new RequestException(
                "Bad request: parameter [userId] value [" . $_REQUEST["userId"] . "] is not numeric.",
                400
            );
        }
        
        $userId = (int)$_REQUEST["userId"];
        $instance = $this->userService->getUserById($userId);
        header("Content-Type: application/json;charset=UTF-8");
        echo $instance->toJson();
    }
    
    /**
     * POST request handler to create a new user record in the database.
     *
     * @throws RequestException
     */
    public function post(): void {
        if (empty($_REQUEST["username"])) {
            throw new RequestException("Bad request: required parameter [username] not found in the request.", 400);
        }
        
        if (empty($_REQUEST["password"])) {
            throw new RequestException("Bad request: required parameter [password] not found in the request.", 400);
        }
        
        if (empty($_REQUEST["email"])) {
            throw new RequestException("Bad request: required parameter [email] not found in the request.", 400);
        }
        
        $instance = $this->userService->createUser(
            $_REQUEST["username"],
            $_REQUEST["password"],
            $_REQUEST["email"]
        );
        header("Content-Type: application/json;charset=UTF-8");
        echo $instance->toJson();
    }
    
    /**
     * PUT request handler to update a user record in the database.
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
        
        if (empty($_REQUEST["userId"])) {
            throw new RequestException("Bad request: required parameter [userId] not found in the request.", 400);
        }
        
        if (!is_numeric($_REQUEST["userId"])) {
            throw new RequestException(
                "Bad request: parameter [userId] value [" . $_REQUEST["userId"] . "] is not numeric.",
                400
            );
        }
        
        if (empty($_REQUEST["username"])) {
            throw new RequestException("Bad request: required parameter [username] not found in the request.", 400);
        }
        
        if (empty($_REQUEST["password"])) {
            throw new RequestException("Bad request: required parameter [password] not found in the request.", 400);
        }
        
        if (empty($_REQUEST["email"])) {
            throw new RequestException("Bad request: required parameter [email] not found in the request.", 400);
        }
        
        $userId = (int)$_REQUEST["userId"];
        
        $instance = $this->userService->updateUser(
            $userId,
            $_REQUEST["username"],
            $_REQUEST["password"],
            $_REQUEST["email"]
        );
        header("Content-Type: application/json;charset=UTF-8");
        echo $instance->toJson();
    }
    
    /**
     * DELETE request handler to delete a user record from the database.
     *
     * @throws RequestException
     */
    public function delete(): void {
        $request_contents = file_get_contents('php://input');
        parse_str($request_contents, $_REQUEST);
        
        if (empty($_REQUEST["userId"])) {
            throw new RequestException("Bad request: required parameter [userId] not found in the request.", 400);
        }
        
        if (!is_numeric($_REQUEST["userId"])) {
            throw new RequestException(
                "Bad request: parameter [userId] value [" . $_REQUEST["userId"] . "] is not numeric.",
                400
            );
        }
        
        $userId = (int) $_REQUEST["userId"];
        
        $this->userService->deleteUserById($userId);
        header("Content-Type: application/json;charset=UTF-8");
        http_response_code(204);
    }
}
