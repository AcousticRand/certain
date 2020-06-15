<?php


namespace App\Document;

use App\Repository\UrlRepository;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document(collection="urls", repositoryClass=UrlRepository::class)
 */
class Url
{
    /**
     * @MongoDB\Id(strategy="AUTO")
     */
    protected $id;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $url;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $customer;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $path;

    /**
     * @MongoDB\Field(type="date")
     */
    protected $expireDate;

    /**
     * @MongoDB\Field(type="date")
     */
    protected $lastValidated;

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
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     * @return Url
     */
    public function setUrl($url): Url
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @param mixed $customer
     * @return Url
     */
    public function setCustomer($customer): Url
    {
        $this->customer = $customer;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param mixed $path
     * @return Url
     */
    public function setPath($path): Url
    {
        $this->path = $path;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getExpireDate()
    {
        return $this->expireDate;
    }

    /**
     * @param mixed $expireDate
     * @return Url
     */
    public function setExpireDate($expireDate): Url
    {
        $this->expireDate = $expireDate;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLastValidated()
    {
        return $this->lastValidated;
    }

    /**
     * @param mixed $lastValidated
     * @return Url
     */
    public function setLastValidated($lastValidated): Url
    {
        $this->lastValidated = $lastValidated;
        return $this;
    }


}
