<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 13/01/17
 * Time: 11:58
 */

namespace Shop\BackendBundle\Model;


use Lib\ValueObject\CostInterface;

class Product implements CostInterface
{
    /**
     * @var string
     */
    private $name = "";
    /**
     * @var float
     */
    private $price = 0;
    /**
     * @var string
     */
    private $description = "";
    /**
     * @var string
     */
    private $reference = "";
    /**
     * @var string
     */
    private $measure = "";
    /**
     * @var float
     */
    private $unit = 0;
    /**
     * @var string
     */
    private $currency = "EUR";
    /**
     * @var float
     */
    private $tax = 0;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Product
     */
    public function setName(string $name): Product
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $price
     *
     * @return Product
     */
    public function setPrice(float $price): Product
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return Product
     */
    public function setDescription(string $description): Product
    {
        $this->description = $description;

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


}