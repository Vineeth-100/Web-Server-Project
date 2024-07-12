<?php
declare(strict_types=1);

namespace Vineeth\DAOS;

use Exception;
use PDO;
use PDOException;
use Teacher\GivenCode\Services\DBConnectionService;
use Vineeth\DTOS\PermissionDTO;

/**
 *
 */
class PermissionDAO {
    public const TABLE_NAME = "permission";
    private const CREATE_QUERY = "INSERT INTO " . self::TABLE_NAME . " (`permission_unique`, `permission_name`, `permission_description`) VALUES (:permissionUnique, :permissionName, :permissionDescription);";
    private const DELETE_QUERY = "DELETE FROM " . self::TABLE_NAME . " WHERE `id` = :id;";
    private const UPDATE_QUERY = "UPDATE " . self::TABLE_NAME . " SET
                                  `permission_unique` = :permissionUnique,
                                  `permission_name` = :permissionName,
                                  `permission_description` = :permissionDescription,
                                  `updated_dt` = current_timestamp(6)
                                  WHERE `id` = :id;";
    private const SELECT_BY_ID_QUERY = "SELECT * FROM " . self::TABLE_NAME . " WHERE `id` = :id;";
    private const SELECT_BY_NAME_QUERY = "SELECT * FROM " . self::TABLE_NAME . " WHERE `permission_name` = :permissionName ";
    
    public function __construct() {}
    
    /**
     * Creates a new permission in the database.
     *
     * @param PermissionDTO $permission
     * @return void
     * @throws Exception
     */
    public function create(PermissionDTO $permission): void {
        try {
            $connection = DBConnectionService::getConnection();
            $statement = $connection->prepare(self::CREATE_QUERY);
            $statement->bindValue(":permissionUnique", $permission->getPermissionUnique(), PDO::PARAM_STR);
            $statement->bindValue(":permissionName", $permission->getPermissionName(), PDO::PARAM_STR);
            $statement->bindValue(":permissionDescription", $permission->getPermissionDescription(), PDO::PARAM_STR);
            $statement->execute();
        } catch (\PDOException $e) {
            throw new Exception("Failed to create permission: " . $e->getMessage());
        }
    }
    
    /**
     * Deletes a permission from the database by its ID.
     *
     * @param int $permissionId
     * @return void
     * @throws Exception
     */
    public function deleteById(int $permissionId): void {
        try {
            $connection = DBConnectionService::getConnection();
            $statement = $connection->prepare(self::DELETE_QUERY);
            $statement->bindValue(":id", $permissionId, PDO::PARAM_INT);
            $statement->execute();
        } catch (PDOException $e) {
            throw new Exception("Failed to delete permission: " . $e->getMessage());
        }
    }
    
    /**
     * Updates a permission in the database.
     *
     * @param PermissionDTO $permission
     * @return void
     * @throws Exception
     */
    public function update(PermissionDTO $permission): void {
        try {
            $connection = DBConnectionService::getConnection();
            $statement = $connection->prepare(self::UPDATE_QUERY);
            $statement->bindValue(":id", $permission->getPermissionId(), PDO::PARAM_INT);
            $statement->bindValue(":permissionUnique", $permission->getPermissionUnique(), PDO::PARAM_STR);
            $statement->bindValue(":permissionName", $permission->getPermissionName(), PDO::PARAM_STR);
            $statement->bindValue(":permissionDescription", $permission->getPermissionDescription(), PDO::PARAM_STR);
            $statement->execute();
        } catch (PDOException $e) {
            throw new Exception("Failed to update permission: " . $e->getMessage());
        }
    }
    
    /**
     * Retrieves a permission from the database by its ID.
     *
     * @param int $permissionId
     * @return PermissionDTO|null
     * @throws Exception
     */
    public function getById(int $permissionId): ?PermissionDTO {
        try {
            $connection = DBConnectionService::getConnection();
            $statement = $connection->prepare(self::SELECT_BY_ID_QUERY);
            $statement->bindValue(":id", $permissionId, PDO::PARAM_INT);
            $statement->execute();
            $permissionData = $statement->fetch(PDO::FETCH_ASSOC);
            if ($permissionData === false) {
                return null;
            }
            $permission = new PermissionDTO();
            $permission->setPermissionId((int)$permissionData['id']);
            $permission->setPermissionUnique($permissionData['permission_unique']);
            $permission->setPermissionName($permissionData['permission_name']);
            $permission->setPermissionDescription($permissionData['permission_description']);
            return $permission;
        } catch (PDOException $e) {
            throw new Exception("Failed to retrieve permission: " . $e->getMessage());
        }
    }
    
    /**
     * Retrieves a permission from the database by its name.
     *
     * @param string $permissionName
     * @return PermissionDTO|null
     * @throws Exception
     */
    public function getByName(string $permissionName) : ?PermissionDTO {
        try {
            $connection = DBConnectionService::getConnection();
            $statement = $connection->prepare(self::SELECT_BY_NAME_QUERY);
            $statement->bindValue(":permissionName", $permissionName, PDO::PARAM_STR);
            $statement->execute();
            $permissionData = $statement->fetch(PDO::FETCH_ASSOC);
            if ($permissionData === false) {
                return null;
            }
            $permission = new PermissionDTO();
            $permission->setPermissionId((int)$permissionData['id']);
            $permission->setPermissionUnique($permissionData['permission_unique']);
            $permission->setPermissionName($permissionData['permission_name']);
            $permission->setPermissionDescription($permissionData['permission_description']);
            return $permission;
        } catch (PDOException $e) {
            throw new Exception("Failed to retrieve permission: " . $e->getMessage());
        }
    }
}
    
