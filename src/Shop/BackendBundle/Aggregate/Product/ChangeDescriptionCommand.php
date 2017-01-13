<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 12/01/17
 * Time: 18:34
 */

namespace Shop\BackendBundle\Aggregate\Product;


use Lib\CQRS\Command;

class ChangeDescriptionCommand extends Command
{
    private $uuid;
    private $description;

    public function __construct($uuid, $description)
    {

        $this->uuid        = $uuid;
        $this->description = $description;
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
    public function getDescription()
    {
        return $this->description;
    }
}