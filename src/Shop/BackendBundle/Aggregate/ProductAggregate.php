<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 12/01/17
 * Time: 17:47
 */

namespace Shop\BackendBundle\Aggregate;


use Lib\CQRS\AggregateAbstract;
use Lib\Factory\CostFactory;
use Lib\ValueObject\Cost;
use Shop\BackendBundle\Aggregate\Product\ProductCreated;
use Shop\BackendBundle\Aggregate\Product\ProductDescriptionChanged;
use Shop\BackendBundle\Aggregate\Product\ProductNameChanged;
use Shop\BackendBundle\Aggregate\Product\ProductPriceChanged;

class ProductAggregate extends AggregateAbstract
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var Cost
     */
    private $cost;
    /**
     * @var string
     */
    private $description;
    /**
     * @var string
     */
    private $reference;
    /**
     * @var \DateTime
     */
    private $createdAt;
    /**
     * @var \DateTime
     */
    private $updatedAt;


    public function create($uuid, $payloads = [])
    {
        $this->uuid = $uuid;
        $this->publish($this->createEvent(ProductCreated::class, $payloads));
    }

    public function changeName($payloads = [])
    {
        $this->publish($this->createEvent(ProductNameChanged::class, $payloads));
    }

    public function changePrice($payloads = [])
    {
        $this->publish($this->createEvent(ProductPriceChanged::class, $payloads));
    }

    public function changeDescription($payloads = [])
    {
        $this->publish($this->createEvent(ProductDescriptionChanged::class, $payloads));
    }

    public function getPayloads()
    {
        return [
            "name"        => $this->name,
            "cost"        => $this->cost,
            "description" => $this->description,
            "reference"   => $this->reference,
            "createdAt"   => $this->createdAt,
            "updatedAt"   => $this->updatedAt,

        ];
    }


    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return Cost
     */
    public function getCost(): Cost
    {
        return $this->cost;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @return string
     */
    public function getReference(): string
    {
        return $this->reference;
    }


    protected function onProductCreated(ProductCreated $event, $isNew)
    {
        $this->name        = $event->find("name");
        $this->reference   = $event->find("reference");
        $this->cost        = $event->find("cost");
        $this->description = $event->find('description');
        $this->updatedAt   = $event->getCreatedAt();
        $this->uuid        = $event->getAggregateUuid();
        $this->createdAt   = $event->getCreatedAt();


    }

    protected function onProductNameChanged(ProductNameChanged $event, $isNew)
    {
        $this->name      = $event->find("name");
        $this->updatedAt = $event->getCreatedAt();

    }

    protected function onProductDescriptionChanged(ProductDescriptionChanged $event, $isNew)
    {
        $this->description = $event->find("description");
        $this->updatedAt   = $event->getCreatedAt();

    }

    protected function onProductPriceChanged(ProductPriceChanged $event, $isNew)
    {
        $this->cost      = $isNew ? $event->find("cost") : CostFactory::createFromArray($event->find("cost"));
        $this->updatedAt = $event->getCreatedAt();

    }


}