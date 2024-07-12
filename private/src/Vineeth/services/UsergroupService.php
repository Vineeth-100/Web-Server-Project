<?php
declare(strict_types=1);

namespace Vineeth\services;

use DateTime;
use Exception;
use Vineeth\DAOs\UserGroupDAO;
use Vineeth\DTOs\UserGroupDTO;

/**
 * Service class to handle operations related to user groups.
 */
class UsergroupService
{
    private UserGroupDAO $userGroupDAO;
    
    public function __construct() {
        $this->userGroupDAO = new UserGroupDAO();
    }
    
    /**
     * Retrieves a user group by its ID.
     *
     * @param int $groupId
     * @return UserGroupDTO|null
     * @throws Exception
     */
    public function getUserGroupById(int $groupId): ?UserGroupDTO {
        return $this->userGroupDAO->getById($groupId);
    }
    
    
    /**
     * Creates a new user group.
     *
     * @param string $groupName
     * @param string|null $groupDescription
     * @return UserGroupDTO
     * @throws Exception
     */
    public function createUserGroup(string $groupName, ?string $groupDescription): UserGroupDTO {
        $userGroup = UserGroupDTO::fromValues($groupName, $groupDescription);
        $userGroup->setCreatedDate(new DateTime());
        $this->userGroupDAO->create($userGroup);
        
        return $userGroup;
    }
    
    /**
     * Updates a user group.
     *
     * @param int $groupId
     * @param string      $groupName
     * @param string|null $groupDescription
     * @return UserGroupDTO
     * @throws Exception
     */
    public function updateUserGroup(int $groupId, string $groupName, ?string $groupDescription): UserGroupDTO {
        $userGroup = $this->userGroupDAO->getById($groupId);
        
        if ($userGroup) {
            $userGroup->setGroupName($groupName);
            $userGroup->setGroupDescription($groupDescription);
            $userGroup->setModifiedDate(new DateTime());
            $this->userGroupDAO->update($userGroup);
        } else {
            throw new Exception("User group with ID $groupId not found.");
        }
        
        return $userGroup;
    }
    
    /**
     * Deletes a user group by its ID.
     *
     * @param int $groupId
     * @throws Exception
     */
    public function deleteUserGroupById(int $groupId): void {
        $userGroup = $this->userGroupDAO->getById($groupId);
        
        if ($userGroup) {
            $this->userGroupDAO->deleteById($groupId);
        } else {
            throw new Exception("User group with ID $groupId not found.");
        }
    }
}
