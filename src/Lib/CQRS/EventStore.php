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
    /*
     * TODO snapshotStorage !!
     */
    /**
     * @var SnapshotStorage
     */
    private $snapshotStorage;

    /**
     * EventStore constructor.
     *
     * @param EventStorageInterface $eventStorage
     */
    public function __construct(EventStorageInterface $eventStorage, SnapshotStorage $snapshotStorage = null)
    {

        $this->eventStorage = $eventStorage;
        $this->snapshotStorage = $snapshotStorage;
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

        if ($this->snapshotStorage) {

            $lastSnaphot = $this->snapshotStorage->getLastSnapShot($uuid);
            if ( ! empty($lastSnaphot)) {
                $stream = $this->eventStorage->getStreamFromPlayhead($uuid, $lastSnaphot["playhead"] + 1);

                array_unshift($stream, $lastSnaphot);
            } else {
                $stream = $this->eventStorage->getStream($uuid);
            }
        } else {
            $stream = $this->eventStorage->getStream($uuid);
        }

        return $stream;
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

    public function canStoreSnapshot()
    {
        return $this->snapshotStorage !== null;
    }

    public function snapshot($uuid)
    {
        // TODO: Implement snapshot() method.
    }
}