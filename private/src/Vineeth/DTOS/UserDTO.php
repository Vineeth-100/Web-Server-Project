<?php
declare(strict_types=1);

namespace Vineeth\DTOS;

use DateTime;
use Teacher\GivenCode\Exceptions\ValidationException;

/**
 *
 */
class UserDTO {
    
    public const TABLE_NAME = "users";
    
    private int $userId;
    private string $username;
    private string $password;
    private string $email;
    private ?DateTime $createdDate;
    private ?DateTime $modifiedDate;
    
    public function __construct() {}
    
    /**
     * @param string $username
     * @param string $password
     * @param string $email
     * @return UserDTO
     */
    public static function fromValues(string $username, string $password, string $email) : UserDTO {
        
        $object = new UserDTO();
        
        $object->setUsername($username);
        $object->setPassword($password);
        $object->setEmail($email);
        
        return $object;
    }
    
    /**
     * @throws ValidationException
     */
    private static function validateDbArray(array $array) : void {
        
        if (empty($array["id"]) && !is_numeric($array["id"])) {
            throw new ValidationException("Record array does not contain an [id] field. Check column names.", 500);
        }
        if (empty($array["username"])) {
            throw new ValidationException("Record array does not contain an [username] field.");
        }
        if (empty($array["password"])) {
            throw new ValidationException("Record array does not contain an [password_hash] field.");
        }
        if (empty($array["email"])) {
            throw new ValidationException("Record array does not contain an [created_at] field.");
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
    
    public function getUserId(): int {
        return $this->userId;
    }
    
    public function setUserId(int $userId): void {
        $this->userId = $userId;
    }
    
    public function getUsername(): string {
        return $this->username;
    }
    
    public function setUsername(string $username): void {
        $this->username = $username;
    }
    
    public function getPassword(): string {
        return $this->password;
    }
    
    public function setPassword(string $password): void {
        $this->password = $password;
    }
    
    public function getEmail(): string {
        return $this->email;
    }
    
    public function setEmail(string $email): void {
        $this->email = $email;
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
    public function toJSON() : array {
        return [
            "id" => $this->getUserId(),
            "username" => $this->getUsername(),
            "passwordHash" => $this->getPassword(),
            "email" => $this->getEmail(),
            "createdDate" => $this->getCreatedDate(),
            "modifiedDate" => $this->getModifiedDate()
        ];
    }
}