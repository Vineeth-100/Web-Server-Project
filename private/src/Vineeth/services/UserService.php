<?php
declare(strict_types=1);

namespace Vineeth\services;

use Exception;
use Vineeth\DAOS\UserDAO;
use Vineeth\DTOS\UserDTO;

/**
 *
 */
class UserService {
    private UserDAO $userDAO;
    
    public function __construct() {
        $this->userDAO = new UserDAO();
    }
    
    /**
     * Retrieves a user by its ID.
     *
     * @param int $userId
     * @return UserDTO|null
     * @throws Exception
     */
    public function getUserById(int $userId) : ?UserDTO {
        return $this->userDAO->getById($userId);
    }
    
    /**
     * Creates a new user.
     *
     * @param string $username
     * @param string $password
     * @param string $email
     * @return UserDTO
     * @throws Exception
     */
    public function createUser(string $username, string $password, string $email) : UserDTO {
        $user = UserDTO::fromValues($username, $password, $email);
        $this->userDAO->create($user);
        
        return $user;
    }
    
    /**
     * Updates a user.
     *
     * @param int $userId
     * @param string $username
     * @param string $password
     * @param string $email
     * @return UserDTO
     * @throws Exception
     */
    public function updateUser(int $userId, string $username, string $password, string $email) : UserDTO {
        $user = $this->userDAO->getById($userId);
        
        if ($user) {
            $user->setUsername($username);
            $user->setPassword($password);
            $user->setEmail($email);
            $this->userDAO->update($user);
        } else {
            throw new Exception("User with ID $userId not found.");
        }
        
        return $user;
    }
    
    /**
     * Deletes a user by its ID.
     *
     * @param int $userId
     * @throws Exception
     */
    public function deleteUserById(int $userId) : void {
        $user = $this->userDAO->getById($userId);
        
        if ($user) {
            $this->userDAO->deleteById($userId);
        } else {
            throw new Exception("User with ID $userId not found.");
        }
    }
    
}