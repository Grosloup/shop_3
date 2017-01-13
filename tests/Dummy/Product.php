<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 12/01/17
 * Time: 12:52
 */

namespace Tests\Dummy;


use Lib\CQRS\AggregateAbstract;

class Product extends AggregateAbstract
{

    private $name;

    private $price;

    private $createdAt;
    /**
     * @var string
     */
    private $description = "bb";
    /**
     * @var \DateTime
     */
    private $updatedAt;

    public function create($uuid, $name, $price)
    {
        $event = new ProductCreated(
            Product::class,
            $uuid,
            $this->playhead,
            [
                "name"  => $name,
                "price" => $price,
            ]
        );
        $this->publish($event);
    }

    public function changeName($name)
    {
        $event = new ProductNameChanged(
            Product::class,
            $this->uuid,
            $this->playhead,
            [
                "name" => $name,
            ]
        );
        $this->publish($event);
    }

    public function changPrice()
    {

    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    protected function onProductCreated(ProductCreated $event)
    {
        $this->name      = $event->find("name");
        $this->price     = $event->find("price");
        $this->uuid      = $event->getAggregateUuid();
        $this->createdAt = $event->getCreatedAt();
        $this->updatedAt = $event->getCreatedAt();
    }

    protected function onProductNameChanged(ProductNameChanged $event)
    {
        $this->name      = $event->find("name");
        $this->updatedAt = $event->getCreatedAt();
    }

    protected function onProductPriceChanged()
    {

    }


}