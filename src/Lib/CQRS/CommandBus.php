<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 10/01/17
 * Time: 20:53
 */

namespace Lib\CQRS;


use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;

class CommandBus implements CommandBusInterface, LoggerAwareInterface
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    private $handlers = [];

    private $queue = [];
    /**
     * @var bool
     */
    private $isDispatching = false;

    public function dispatch(CommandInterface $command)
    {

        $this->queue[] = $command;

        if ( ! $this->isDispatching) {
            $this->isDispatching = true;

            while ($c = array_shift($this->queue)) {
                $key = $c->getHandlerName();
                if (array_key_exists($key, $this->handlers)) {
                    /** @var CommandHandlerAbstract $handler */
                    $handler = $this->handlers[$key];

                    $handler->handle($c);
                }
            }

            $this->isDispatching = false;
        }


        /*$key = $command->getHandlerName();
        if (array_key_exists($key, $this->handlers)) {

            $handler = $this->handlers[$key];

            return $handler->handle($command);
        }*/
        //return false;
    }

    public function registerHandler(CommandHandlerInterface $commandHandler)
    {
        $this->handlers[$commandHandler->getName()] = $commandHandler;

        return $this;
    }

    /**
     * Sets a logger instance on the object.
     *
     * @param LoggerInterface $logger
     *
     * @return void
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function getHandlers()
    {
        return $this->handlers;
    }
}