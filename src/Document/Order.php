<?php


namespace App\Document;

use App\Repository\CustomerRepository;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document(collection="orders")
 */
class Order
{
    /**
     * @MongoDB\Id(strategy="AUTO")
     */
    private $id;

    /**
     * @MongoDB\Field(type="string")
     */
    private $code;

    /**
     * @MongoDB\ReferenceMany(targetDocument=Item::class, cascade="all")
     */
    private $items = [];

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Order
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
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
     * @return Order
     */
    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param array $items
     * @return Order
     */
    public function setItems(array $items): Order
    {
        $this->items = $items;
        return $this;
    }


}
