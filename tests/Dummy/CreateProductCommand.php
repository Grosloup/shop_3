<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 12/01/17
 * Time: 12:56
 */

namespace Tests\Dummy;


use Lib\CQRS\Command;

class CreateProductCommand extends Command
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var float
     */
    private $price;
    /**
     * @var string
     */
    private $uuid;

    public function __construct($uuid, $name, $price)
    {
        $this->name  = $name;
        $this->price = $price;
        $this->uuid  = $uuid;
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
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }


}