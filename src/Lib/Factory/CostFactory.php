<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 13/01/17
 * Time: 12:58
 */

namespace Lib\Factory;


use Lib\ValueObject\Cost;
use Lib\ValueObject\CostInterface;

class CostFactory
{
    public static function create(CostInterface $object)
    {
        return new Cost(
            $object->getPrice(),
            $object->getMeasure(),
            $object->getUnit(),
            $object->getTax(),
            $object->getCurrency()
        );
    }

    public static function createFromArray($cost = [])
    {
        return new Cost(
            $cost["price"],
            $cost["measure"],
            $cost["unit"],
            $cost["tax"],
            $cost["currency"]
        );
    }
}