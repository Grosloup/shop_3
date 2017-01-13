<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 10/01/17
 * Time: 20:51
 */

namespace Lib\CQRS;


interface CommandBusInterface
{
    public function dispatch(CommandInterface $command);

    public function registerHandler(CommandHandlerInterface $commandHandler);
}