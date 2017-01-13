<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 13/01/17
 * Time: 13:00
 */

namespace Lib\ValueObject;


interface CostInterface
{
    public function getCurrency(): string;

    public function getPrice(): float;

    public function getMeasure(): string;

    public function getUnit(): float;

    public function getTax(): float;
}