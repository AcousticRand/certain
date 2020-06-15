<?php


namespace App\Document;

use App\Repository\PersonnelRepository;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document(collection="personnel", repositoryClass=PersonnelRepository::class)
 */
class Personnel
{
    /**
     * @MongoDB\Id(strategy="AUTO")
     */
    protected $id;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $code;

    /**
     * @MongoDB\Field(type="collection")
     */
    protected $roles;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $email;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $firstname;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $lastname;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param mixed $code
     * @return Personnel
     */
    public function setCode($code): Personnel
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @param mixed $roles
     * @return Personnel
     */
    public function setRoles($roles): Personnel
    {
        $this->roles = $roles;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     * @return Personnel
     */
    public function setEmail($email): Personnel
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    /**
     * @param mixed $firstname
     * @return Personnel
     */
    public function setFirstname($firstname): Personnel
    {
        $this->firstname = $firstname;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLastname(): string
    {
        return $this->lastname;
    }

    /**
     * @param mixed $lastname
     * @return Personnel
     */
    public function setLastname($lastname): Personnel
    {
        $this->lastname = $lastname;
        return $this;
    }


    /**
     * @return mixed
     */
    public function getFullName(): string
    {
        return $this->firstname . ' ' . $this->lastname;
    }

    /**
     * @return mixed
     */
    public function getLastNameFirst(): string
    {
        return $this->lastname . ', ' . $this->firstname;
    }

}
