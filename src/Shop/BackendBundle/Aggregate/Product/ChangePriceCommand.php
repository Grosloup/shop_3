<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 12/01/17
 * Time: 18:30
 */

namespace Shop\BackendBundle\Aggregate\Product;


use Lib\CQRS\Command;
use Lib\ValueObject\Cost;

class ChangePriceCommand extends Command
{
    /**
     * @var string
     */
    private $uuid;
    /**
     * @var Cost
     */
    private $cost;

    public function __construct(string $uuid, Cost $cost)
    {

        $this->uuid = $uuid;
        $this->cost = $cost;
    }

    /**
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }

    /**
     * @return Cost
     */
    public function getCost(): Cost
    {
        return $this->cost;
    }


}