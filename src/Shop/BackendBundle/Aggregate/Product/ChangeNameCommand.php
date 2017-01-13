<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 12/01/17
 * Time: 13:43
 */

namespace Shop\BackendBundle\Aggregate\Product;


use Lib\CQRS\Command;

class ChangeNameCommand extends Command
{
    private $uuid;
    private $name;

    public function __construct($uuid, $name)
    {

        $this->uuid = $uuid;
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getUuid()
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


}