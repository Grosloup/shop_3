<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 10/01/17
 * Time: 20:24
 */

namespace Lib\CQRS;


use Lib\CQRS\Exception\InvalidUuidException;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;

class EventStore implements EventStoreInterface, LoggerAwareInterface
{
    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @var \Lib\CQRS\EventStorageInterface
     */
    private $eventStorage;

    /**
     * EventStore constructor.
     *
     * @param EventStorageInterface $eventStorage
     */
    public function __construct(EventStorageInterface $eventStorage)
    {

        $this->eventStorage = $eventStorage;
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

    /**
     * @param string $uuid
     *
     * @return mixed
     */
    public function getEventStream($uuid)
    {
        if ( ! is_string($uuid)) {
            throw new InvalidUuidException();
        }

        return $this->eventStorage->getStream($uuid);
    }

    /**
     * @param string $uuid
     *
     * @return mixed
     */
    public function getCurrentPlayHead($uuid)
    {
        if ( ! is_string($uuid)) {
            throw new InvalidUuidException();
        }

        return $this->eventStorage->getPlayhead($uuid);
    }

    /**
     * @param Event $event
     * @param AggregateInterface $aggregate
     *
     * @return mixed
     */
    public function saveEvent(Event $event, AggregateInterface $aggregate)
    {
        return $this->eventStorage->saveEvent($event);
    }
}