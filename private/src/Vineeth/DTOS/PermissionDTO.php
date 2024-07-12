<?php
declare(strict_types=1);

namespace Vineeth\DTOS;

use DateTime;
use Teacher\GivenCode\Exceptions\ValidationException;

/**
 *
 */
class PermissionDTO {
    public const TABLE_NAME = "permission";
    
    private int $permissionId;
    private string $permissionUnique;
    private string $permissionName;
    private ?string $permissionDescription;
    private ?DateTime $createdDate;
    private ?DateTime $modifiedDate;
    
    public function __construct() {}
    
    /**
     * @param string      $permissionUnique
     * @param string      $permissionName
     * @param string|null $permissionDescription
     * @return PermissionDTO
     */
    public static function fromValues(string  $permissionUnique, string $permissionName,
                                      ?string $permissionDescription) : PermissionDTO {
        $object = new PermissionDTO();
        
        $object->setPermissionUnique($permissionUnique);
        $object->setPermissionName($permissionName);
        $object->setPermissionDescription($permissionDescription);
        
        return $object;
    }
    
    /**
     * @throws ValidationException
     */
    private static function validateDbArray(array $array) : void {
        if (empty($array["id"]) && !is_numeric($array["id"])) {
            throw new ValidationException("Record array does not contain an [id] field. Check column names.", 500);
        }
        if (empty($array["permission_unique"])) {
            throw new ValidationException("Record array does not contain an [permission_unique] field.");
        }
        if (empty($array["permission_name"])) {
            throw new ValidationException("Record array does not contain an [permission_name] field.");
        }
        if (DateTime::createFromFormat(DB_DATETIME_FORMAT, $array["created_dt"]) === false) {
            throw new ValidationException("Failed to parse [created_dt] field as DateTime.");
        }
        if (!empty($array["updated_dt"]) &&
            (DateTime::createFromFormat(DB_DATETIME_FORMAT, $array["updated_dt"]) === false)
        ) {
            throw new ValidationException("Failed to parse [updated_dt] field as DateTime.");
        }
    }
    
    public function getPermissionId() : int {
        return $this->permissionId;
    }
    
    public function setPermissionId(int $permissionId) : void {
        $this->permissionId = $permissionId;
    }
    
    public function getPermissionUnique() : string {
        return $this->permissionUnique;
    }
    
    public function setPermissionUnique(string $permissionUnique) : void {
        $this->permissionUnique = $permissionUnique;
    }
    
    public function getPermissionName() : string {
        return $this->permissionName;
    }
    
    public function setPermissionName(string $permissionName) : void {
        $this->permissionName = $permissionName;
    }
    
    public function getPermissionDescription() : ?string {
        return $this->permissionDescription;
    }
    
    public function setPermissionDescription(?string $permissionDescription) : void {
        $this->permissionDescription = $permissionDescription;
    }
    
    public function getCreatedDate() : ?DateTime {
        return $this->createdDate;
    }
    
    public function setCreatedDate(?DateTime $createdDate) : void {
        $this->createdDate = $createdDate;
    }
    
    public function getModifiedDate() : ?DateTime {
        return $this->modifiedDate;
    }
    
    public function setModifiedDate(?DateTime $modifiedDate) : void {
        $this->modifiedDate = $modifiedDate;
    }
    
    /**
     * @return array
     */
    public function toJSON() : array {
        return [
            "id" => $this->getPermissionId(),
            "permission_unique" => $this->getPermissionUnique(),
            "permission_name" => $this->getPermissionName(),
            "permission_description" => $this->getPermissionDescription(),
            "createdDate" => $this->getCreatedDate(),
            "modifiedDate" => $this->getModifiedDate()
        ];
    }
}
