<?php

namespace Shop\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Lib\ValueObject\CostInterface;

/**
 * Product
 *
 * @ORM\Table(name="product")
 * @ORM\Entity(repositoryClass="Shop\BackendBundle\Repository\ProductRepository")
 */
class Product implements CostInterface
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @var string
     * @ORM\Column(name="uuid", type="string", length=255)
     */
    private $uuid;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     */
    private $price;
    /**
     * @var string
     *
     * @ORM\Column(name="currency", type="string")
     */
    private $currency;
    /**
     * @var string
     *
     * @ORM\Column(name="measure", type="string")
     */
    private $measure;
    /**
     * @var float
     *
     * @ORM\Column(name="unit", type="float")
     */
    private $unit;
    /**
     * @var float
     *
     * @ORM\Column(name="tax", type="float")
     */
    private $tax;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;
    /**
     * @var string
     *
     * @ORM\Column(name="reference", type="text")
     */
    private $reference;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }

    /**
     * @param string $uuid
     *
     * @return Product
     */
    public function setUuid(string $uuid): Product
    {
        $this->uuid = $uuid;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Product
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * Set price
     *
     * @param float $price
     *
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     *
     * @return Product
     */
    public function setCurrency(string $currency): Product
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * @return string
     */
    public function getMeasure(): string
    {
        return $this->measure;
    }

    /**
     * @param string $measure
     *
     * @return Product
     */
    public function setMeasure(string $measure): Product
    {
        $this->measure = $measure;

        return $this;
    }

    /**
     * @return float
     */
    public function getUnit(): float
    {
        return $this->unit;
    }

    /**
     * @param float $unit
     *
     * @return Product
     */
    public function setUnit(float $unit): Product
    {
        $this->unit = $unit;

        return $this;
    }

    /**
     * @return float
     */
    public function getTax(): float
    {
        return $this->tax;
    }

    /**
     * @param float $tax
     *
     * @return Product
     */
    public function setTax(float $tax): Product
    {
        $this->tax = $tax;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Product
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Product
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Product
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return string
     */
    public function getReference(): string
    {
        return $this->reference;
    }

    /**
     * @param string $reference
     *
     * @return Product
     */
    public function setReference(string $reference): Product
    {
        $this->reference = $reference;

        return $this;
    }


}

