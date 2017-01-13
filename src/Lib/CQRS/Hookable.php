<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 12/01/17
 * Time: 20:42
 */

namespace Lib\CQRS;


trait Hookable
{
    protected $hooks = [];

    public function addHook(HookInterface $hook)
    {
        $this->hooks[] = $hook;

        return $this;
    }
}