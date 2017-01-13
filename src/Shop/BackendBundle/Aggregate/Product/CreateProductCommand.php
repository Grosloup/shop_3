<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 12/01/17
 * Time: 12:56
 */

namespace Shop\BackendBundle\Aggregate\Product;


use Lib\CQRS\Command;
use Lib\ValueObject\Cost;

class CreateProductCommand extends Command
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
    /**
     * @var string
     */
    private $description;
    /**
     * @var string
     */
    private $uuid;
    /**
     * @var
     */
    private $reference;

    public function __construct($uuid, $name, Cost $cost, $description, $reference)
    {
        $this->name        = $name;
        $this->cost        = $cost;
        $this->uuid        = $uuid;
        $this->description = $description;
        $this->reference   = $reference;
    }

    /**
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
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
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getReference()
    {
        return $this->reference;
    }


}