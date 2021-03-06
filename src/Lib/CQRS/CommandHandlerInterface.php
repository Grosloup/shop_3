<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 10/01/17
 * Time: 20:49
 */

namespace Lib\CQRS;


interface CommandHandlerInterface
{
    public function handle(CommandInterface $command);

    public function getName();
}