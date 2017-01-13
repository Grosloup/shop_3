<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 11/01/17
 * Time: 00:19
 */

namespace Lib\CQRS;


class Command implements CommandInterface
{

    /**
     * The CommandHandler class name (short) which will
     * handle this
     * @return string
     */
    public function getHandlerName()
    {
        return $this->getInternalName()."Handler";
    }

    /**
     * The class name (short) of this
     * @return string
     */
    public function getInternalName()
    {
        $fqn   = get_class($this);
        $parts = explode("\\", $fqn);

        return end($parts);
    }
}