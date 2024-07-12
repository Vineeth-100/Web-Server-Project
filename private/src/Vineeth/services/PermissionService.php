<?php
declare(strict_types=1);

namespace Vineeth\services;

use Exception;
use Vineeth\DAOS\PermissionDAO;
use Vineeth\DTOS\PermissionDTO;

/**
 *
 */
class PermissionService {
    private PermissionDAO $permissionDAO;
    
    public function __construct() {
        $this->permissionDAO = new PermissionDAO();
    }
    
    /**
     * Retrieves a permission by its ID.
     *
     * @param int $permissionId
     * @return PermissionDTO|null
     * @throws Exception
     */
    public function getPermissionById(int $permissionId) : ?PermissionDTO {
        return $this->permissionDAO->getById($permissionId);
    }
    
    /**
     * Creates a new permission.
     *
     * @param string $permissionUnique
     * @param string $permissionName
     * @param string $permissionDescription
     * @return PermissionDTO
     * @throws Exception
     */
    public function createPermission(string $permissionUnique, string $permissionName, string $permissionDescription): PermissionDTO {
        $permission = new PermissionDTO();
        $permission->setPermissionUnique($permissionUnique);
        $permission->setPermissionName($permissionName);
        $permission->setPermissionDescription($permissionDescription);
        
        $this->permissionDAO->create($permission);
        
        return $permission;
    }
    
    /**
     * Updates a permission.
     *
     * @param int    $permissionId
     * @param string $permissionUnique
     * @param string $permissionName
     * @param string $permissionDescription
     * @return PermissionDTO
     * @throws Exception
     */
    public function updatePermission(int    $permissionId, string $permissionUnique, string $permissionName,
                                     string $permissionDescription) : PermissionDTO {
        $permission = $this->permissionDAO->getById($permissionId);
        
        if ($permission) {
            $permission->setPermissionUnique($permissionUnique);
            $permission->setPermissionName($permissionName);
            $permission->setPermissionDescription($permissionDescription);
            
            $this->permissionDAO->update($permission);
        } else {
            throw new Exception("Permission with ID $permissionId not found.");
        }
        
        return $permission;
    }
    
    /**
     * Deletes a permission by its ID.
     *
     * @param int $permissionId
     * @throws Exception
     */
    public function deletePermissionById(int $permissionId): void {
        $permission = $this->permissionDAO->getById($permissionId);
        
        if ($permission) {
            $this->permissionDAO->deleteById($permissionId);
        } else {
            throw new Exception("Permission with ID $permissionId not found.");
        }
    }

}