<?php


namespace App\Document;

use App\Repository\CustomerRepository;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document(collection="customers", repositoryClass=CustomerRepository::class)
 */
class Customer
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
     * @MongoDB\Field(type="string")
     */
    protected $name;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $company;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $pm;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $platform;

    /**
     * @MongoDB\Field(type="collection")
     */
    protected $urls;


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
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param mixed $code
     * @return Customer
     */
    public function setCode($code): Customer
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return Customer
     */
    public function setName($name): Customer
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @param mixed $company
     * @return Customer
     */
    public function setCompany($company): Customer
    {
        $this->company = $company;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPm()
    {
        return $this->pm;
    }

    /**
     * @param mixed $pm
     * @return Customer
     */
    public function setPm($pm): Customer
    {
        $this->pm = $pm;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPlatform()
    {
        return $this->platform;
    }

    /**
     * @param mixed $platform
     * @return Customer
     */
    public function setPlatform($platform): Customer
    {
        $this->platform = $platform;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUrls()
    {
        return $this->urls;
    }

    /**
     * @param mixed $urls
     * @return Customer
     */
    public function setUrls($urls): Customer
    {
        $this->urls = $urls;
        return $this;
    }


}
