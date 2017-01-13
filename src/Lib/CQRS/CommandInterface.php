<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 10/01/17
 * Time: 20:49
 */

namespace Lib\CQRS;


interface CommandInterface
{
    public function getHandlerName();
}