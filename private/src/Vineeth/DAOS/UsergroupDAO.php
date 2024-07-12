<?php
declare(strict_types=1);

namespace Vineeth\DAOS;

use DateTime;
use Exception;
use PDO;
use PDOException;
use Teacher\GivenCode\Services\DBConnectionService;
use Vineeth\DTOS\UsergroupDTO;

class UsergroupDAO {
    
    public const TABLE_NAME = "user_groups";
    
    private const CREATE_QUERY = "INSERT INTO " . self::TABLE_NAME . " (`group_name`, `group_description`, `created_dt`)
                                    VALUES (:groupName, :groupDescription, :createdDate);";
    
    private const DELETE_QUERY = "DELETE FROM " . self::TABLE_NAME . " WHERE `id` = :id;";
    
    private const UPDATE_QUERY = "UPDATE " . self::TABLE_NAME . " SET
                                    `group_name` = :groupName,
                                    `group_description` = :groupDescription,
                                    `updated_dt` = current_timestamp(6)
                                    WHERE `id` = :id;";
    
    private const SELECT_BY_ID_QUERY = "SELECT * FROM " . self::TABLE_NAME . " WHERE `id` = :id;";
    
    private const SELECT_BY_NAME_QUERY = "SELECT * FROM " . self::TABLE_NAME . " WHERE `group_name` = :groupName;";
    
    public function __construct() {}
    
    /**
     * Creates a new usergroup in the database.
     *
     * @param UsergroupDTO $usergroup
     * @return void
     * @throws Exception
     */
    public function create(UsergroupDTO $usergroup): void {
        try {
            $connection = DBConnectionService::getConnection();
            $statement = $connection->prepare(self::CREATE_QUERY);
            $statement->bindValue(":groupName", $usergroup->getGroupName(), PDO::PARAM_STR);
            $statement->bindValue(":groupDescription", $usergroup->getGroupDescription(), PDO::PARAM_STR);
            $statement->bindValue(":createdDate", $usergroup->getCreatedDate()->format('Y-m-d H:i:s.u'), PDO::PARAM_STR);
            $statement->execute();
        } catch (PDOException $e) {
            throw new Exception("Failed to create usergroup: " . $e->getMessage());
        }
    }
    
    
    public function deleteById(int $usergroupId): void {
        try {
            $connection = DBConnectionService::getConnection();
            $statement = $connection->prepare(self::DELETE_QUERY);
            $statement->bindValue(":id", $usergroupId, PDO::PARAM_INT);
            $statement->execute();
        } catch (PDOException $e) {
            throw new Exception("Failed to delete usergroup: " . $e->getMessage());
        }
    }
    
    public function update(UsergroupDTO $usergroup): void {
        try {
            $connection = DBConnectionService::getConnection();
            $statement = $connection->prepare(self::UPDATE_QUERY);
            $statement->bindValue(":id", $usergroup->getId(), PDO::PARAM_INT);
            $statement->bindValue(":groupName", $usergroup->getGroupName(), PDO::PARAM_STR);
            $statement->bindValue(":groupDescription", $usergroup->getGroupDescription(), PDO::PARAM_STR);
            $statement->execute();
        } catch (PDOException $e) {
            throw new Exception("Failed to update usergroup: " . $e->getMessage());
        }
    }
    
    public function getById(int $usergroupId): ?UsergroupDTO {
        try {
            $connection = DBConnectionService::getConnection();
            $statement = $connection->prepare(self::SELECT_BY_ID_QUERY);
            $statement->bindValue(":id", $usergroupId, PDO::PARAM_INT);
            $statement->execute();
            $usergroupData = $statement->fetch(PDO::FETCH_ASSOC);
            if ($usergroupData === false) {
                return null;
            }
            $usergroup = new UsergroupDTO();
            $usergroup->setId((int)$usergroupData['id']);
            $usergroup->setGroupName($usergroupData['group_name']);
            $usergroup->setGroupDescription($usergroupData['group_description']);
            $usergroup->setCreatedDate(new \DateTime($usergroupData['created_dt']));
            $usergroup->setModifiedDate($usergroupData['updated_dt'] ? new DateTime($usergroupData['updated_dt']) : null);
            return $usergroup;
        } catch (PDOException $e) {
            throw new Exception("Failed to retrieve usergroup: " . $e->getMessage());
        }
    }

}