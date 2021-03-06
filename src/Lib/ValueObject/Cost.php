<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 13/01/17
 * Time: 12:18
 */

namespace Lib\ValueObject;
use Webmozart\Assert\Assert;


/**
 * Class Cost
 * @package Lib\CQRS\ValueObject
 */
class Cost implements CostInterface, \JsonSerializable
{
    public static $measures = [
        "unité"       => "unit",
        "g"           => "g",
        "kg"          => "kg",
        "tonne"       => "tone",
        "centimètre"  => "centimeter",
        "mètre"       => "meter",
        "mètre carré" => "square meter",
        "litre"       => "liter",
        "mètre cube"  => "cubic meter",
    ];
    /**
     * @var string
     */
    private $currency = "EUR";

    /**
     * @var float
     */
    private $price = 0.01;

    /**
     * @var string
     */
    private $measure = "unit";

    /**
     * @var float
     */
    private $unit = 1;

    /**
     * @var float
     */
    private $tax = 0;

    /**
     * Cost constructor.
     *
     * @param string $currency
     * @param int $price
     * @param string $measure
     * @param string $unit
     * @param int $tax
     */
    public function __construct($price, $measure, $unit, $tax, $currency = "EUR")
    {
        $this->currency = $currency;
        $this->price    = $price;
        $this->measure  = $measure;
        $this->unit     = $unit;
        $this->tax      = $tax;
    }

    private function checkPrice($price)
    {
        Assert::float($price, "Price is not a valid number");
        Assert::greaterThanEq($price, 0, "Price could not be negative");
        Assert::lessThanEq($price, 10000000000, "Price too high");
        // todo round price
    }

    public function equal(Cost $cost)
    {
        return (
            $this->price === $cost->getPrice() &&
            $this->measure === $cost->getMeasure() &&
            $this->unit === $cost->getUnit() &&
            $this->tax === $cost->getTax() &&
            $this->currency === $cost->getCurrency()
        );
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @return string
     */
    public function getMeasure(): string
    {
        return $this->measure;
    }

    /**
     * @return float
     */
    public function getUnit(): float
    {
        return $this->unit;
    }

    /**
     * @return float
     */
    public function getTax(): float
    {
        return $this->tax;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    function jsonSerialize()
    {
        return [
            "currency" => $this->currency,
            "price"    => $this->price,
            "measure"  => $this->measure,
            "unit"     => $this->unit,
            "tax"      => $this->tax,
        ];
    }


}