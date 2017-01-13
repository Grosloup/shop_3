<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 10/01/17
 * Time: 16:09
 */

namespace Lib\CQRS;


use Lib\CQRS\Exception\InvalidEventNameException;
use Lib\CQRS\Exception\InvalidListenerException;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;

class EventBus implements LoggerAwareInterface
{
    /**
     * @var array
     */
    protected $listeners = [];
    /**
     * @var LoggerInterface
     */
    protected $logger;

    public function registerListeners($listeners = [])
    {

        foreach ($listeners as $eventname => $callable) {
            if ( ! is_callable($callable)) {
                continue;
            }
            $this->registerListener($eventname, $callable);
        }
    }

    /**
     * @param $eventname
     * @param $callable
     *
     * @return $this
     * @throws InvalidEventNameException
     * @throws InvalidListenerException
     */
    public function registerListener($eventname, $callable)
    {
        if ( ! is_string($eventname) || $eventname == "") {
            throw new InvalidEventNameException("The event name must be a not empty string");
        }

        if ( ! is_callable($callable)) {
            throw new InvalidListenerException("The second argument must be callable");
        }


        if ( ! array_key_exists($eventname, $this->listeners)) {
            $this->listeners[$eventname] = [];
        }
        $this->listeners[$eventname][] = $callable;

        return $this;
    }

    public function getListeners()
    {
        return $this->listeners;
    }

    public function dispatch(Event $event, AggregateInterface $aggregate)
    {
        if (array_key_exists($event->getName(), $this->listeners)) {
            if ($this->logger) {
                $this->logger->debug("Event ".$event->getName()." dispatched");
            }
            foreach ($this->listeners[$event->getName()] as $listener) {
                call_user_func_array($listener, [&$event, &$aggregate]);
            }
        } else {
            if ($this->logger) {
                $this->logger->debug("Event ".$event->getName()." has no listeners");
            }
        }
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
}