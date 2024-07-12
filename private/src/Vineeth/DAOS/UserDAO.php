<?php
declare(strict_types=1);

namespace Vineeth\DAOS;

use DateTime;
use Exception;
use PDO;
use PDOException;
use Teacher\GivenCode\Services\DBConnectionService;
use Vineeth\DTOS\UserDTO;

/**
 *
 */
class UserDAO {
    
    public const TABLE_NAME = "users";
    
    private const CREATE_QUERY = "INSERT INTO " . self::TABLE_NAME . " (`username`, `password`, `email`, `created_dt`)
                                    VALUES (:username, :password, :email, :createdDate);";
    
    private const DELETE_QUERY = "DELETE FROM " . self::TABLE_NAME . " WHERE `id` = :id;";
    
    private const UPDATE_QUERY = "UPDATE " . self::TABLE_NAME . " SET
                                    `username` = :username,
                                    `password` = :password,
                                    `email` = :email,
                                    `updated_dt` = current_timestamp(6)
                                    WHERE `id` = :id;";
    
    private const SELECT_BY_ID_QUERY = "SELECT * FROM " . self::TABLE_NAME . " WHERE `id` = :id;";
    
    private const SELECT_BY_USERNAME_QUERY = "SELECT * FROM " . self::TABLE_NAME . " WHERE `username` = :username;";
    
    private const SELECT_BY_EMAIL_QUERY = "SELECT * FROM " . self::TABLE_NAME . " WHERE `email` = :email;";
    
    public function __construct() {}
    
    /**
     * Creates a new user in the database.
     *
     * @param UserDTO $user
     * @return void
     * @throws Exception
     */
    public function create(UserDTO $user) : void {
        try {
            $connection = DBConnectionService::getConnection();
            $statement = $connection->prepare(self::CREATE_QUERY);
            $statement->bindValue(":username", $user->getUsername(), PDO::PARAM_STR);
            $statement->bindValue(":password", $user->getPassword(), PDO::PARAM_STR);
            $statement->bindValue(":email", $user->getEmail(), PDO::PARAM_STR);
            $statement->bindValue(":createdDate", $user->getCreatedDate()->format('Y-m-d H:i:s.u'), PDO::PARAM_STR);
            $statement->execute();
        } catch (PDOException $e) {
            throw new Exception("Failed to create user: " . $e->getMessage());
        }
    }
    
    /**
     * Deletes a user from the database by its ID.
     *
     * @param int $userId
     * @return void
     * @throws Exception
     */
    public function deleteById(int $userId) : void {
        try {
            $connection = DBConnectionService::getConnection();
            $statement = $connection->prepare(self::DELETE_QUERY);
            $statement->bindValue(":id", $userId, PDO::PARAM_INT);
            $statement->execute();
        } catch (PDOException $e) {
            throw new Exception("Failed to delete user: " . $e->getMessage());
        }
    }
    
    /**
     * Updates a user in the database.
     *
     * @param UserDTO $user
     * @return void
     * @throws Exception
     */
    public function update(UserDTO $user) : void {
        try {
            $connection = DBConnectionService::getConnection();
            $statement = $connection->prepare(self::UPDATE_QUERY);
            $statement->bindValue(":id", $user->getUserId(), PDO::PARAM_INT);
            $statement->bindValue(":username", $user->getUsername(), PDO::PARAM_STR);
            $statement->bindValue(":password", $user->getPassword(), PDO::PARAM_STR);
            $statement->bindValue(":email", $user->getEmail(), PDO::PARAM_STR);
            $statement->execute();
        } catch (PDOException $e) {
            throw new Exception("Failed to update user: " . $e->getMessage());
        }
    }
    
    /**
     * Retrieves a user from the database by its ID.
     *
     * @param int $userId
     * @return UserDTO|null
     * @throws Exception
     */
    public function getById(int $userId) : ?UserDTO {
        try {
            $connection = DBConnectionService::getConnection();
            $statement = $connection->prepare(self::SELECT_BY_ID_QUERY);
            $statement->bindValue(":id", $userId, PDO::PARAM_INT);
            $statement->execute();
            $userData = $statement->fetch(PDO::FETCH_ASSOC);
            if ($userData === false) {
                return null;
            }
            $user = new UserDTO();
            $user->setUserId((int) $userData['id']);
            $user->setUsername($userData['username']);
            $user->setPassword($userData['password']);
            $user->setEmail($userData['email']);
            $user->setCreatedDate(new DateTime($userData['created_dt']));
            $user->setModifiedDate($userData['updated_dt'] ? new DateTime($userData['updated_dt']) : null);
            return $user;
        } catch (PDOException $e) {
            throw new Exception("Failed to retrieve user: " . $e->getMessage());
        }
    }
}

    