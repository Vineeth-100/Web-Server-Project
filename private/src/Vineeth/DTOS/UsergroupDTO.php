<?php
declare(strict_types=1);

namespace Vineeth\DTOS;

use DateTime;
use Teacher\GivenCode\Exceptions\ValidationException;

class UsergroupDTO {
    public const TABLE_NAME = "user_groups";
    
    private int $groupId;
    private string $groupName;
    private ?string $groupDescription;
    private ?DateTime $createdDate;
    private ?DateTime $modifiedDate;
    
    public function __construct() {}
    
    /**
     * @param string $groupName
     * @param string|null $groupDescription
     * @return UserGroupDTO
     */
    public static function fromValues(string $groupName, ?string $groupDescription): UserGroupDTO {
        $object = new UserGroupDTO();
        
        $object->setGroupName($groupName);
        $object->setGroupDescription($groupDescription);
        
        return $object;
    }
    
    /**
     * @throws ValidationException
     */
    private static function validateDbArray(array $array): void {
        if (empty($array["id"]) && !is_numeric($array["id"])) {
            throw new ValidationException("Record array does not contain an [id] field. Check column names.", 500);
        }
        if (empty($array["group_name"])) {
            throw new ValidationException("Record array does not contain an [group_name] field.");
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
    
    public function getGroupId(): int {
        return $this->groupId;
    }
    
    public function setGroupId(int $groupId): void {
        $this->groupId = $groupId;
    }
    
    public function getGroupName(): string {
        return $this->groupName;
    }
    
    public function setGroupName(string $groupName): void {
        $this->groupName = $groupName;
    }
    
    public function getGroupDescription(): ?string {
        return $this->groupDescription;
    }
    
    public function setGroupDescription(?string $groupDescription): void {
        $this->groupDescription = $groupDescription;
    }
    
    public function getCreatedDate(): ?DateTime {
        return $this->createdDate;
    }
    
    public function setCreatedDate(?DateTime $createdDate): void {
        $this->createdDate = $createdDate;
    }
    
    public function getModifiedDate(): ?DateTime {
        return $this->modifiedDate;
    }
    
    public function setModifiedDate(?DateTime $modifiedDate): void {
        $this->modifiedDate = $modifiedDate;
    }
    
    /**
     * @return array
     */
    public function toJSON(): array {
        return [
            "id" => $this->getGroupId(),
            "group_name" => $this->getGroupName(),
            "group_description" => $this->getGroupDescription(),
            "createdDate" => $this->getCreatedDate(),
            "modifiedDate" => $this->getModifiedDate()
        ];
    }
    
}