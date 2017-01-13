<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 11/01/17
 * Time: 00:57
 */

namespace Lib\CQRS;


use Lib\CQRS\Exception\ConcurrentAccessException;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;

abstract class AggregateAbstract implements AggregateInterface, LoggerAwareInterface
{
    /**
     * @var LoggerInterface
     */
    protected $logger;
    /**
     * @var EventBus
     */
    protected $eventBus;
    /**
     * @var EventStoreInterface
     */
    protected $eventStore;
    /**
     * @var int
     */
    protected $playhead = -1;
    /**
     * @var string
     */
    protected $uuid;
    /**
     * @var array
     */
    protected $events = [];

    public static function loadFromStream($stream = [])
    {
        if ( ! is_array($stream)) {
            $stream = (array)$stream;
        }
        $static = new static();
        if ( ! empty($stream)) {
            foreach ($stream as $event) {
                $class       = $event["name"];
                $evtInstance = new $class(
                    $event["aggregateType"],
                    $event["aggregateUuid"],
                    $event["playhead"],
                    json_decode($event["payloads"], true),
                    ($event["createdAt"] instanceof \DateTime) ? $event["createdAt"] : new \DateTime(
                        $event["createdAt"]
                    )
                //
                );
                $static->apply($evtInstance, false);
                $static->events[] = $evtInstance;
            }
        }

        return $static;
    }

    /**
     * @param Event $event
     * @param bool $isNew
     */
    public function apply(Event $event, $isNew = true)
    {
        $fqn       = get_class($event);
        $parts     = explode("\\", $fqn);
        $classname = end($parts);
        $method    = "on".$classname;
        if (method_exists($this, $method)) {
            if ( ! $isNew) {
                $this->playhead = $event->getPlayhead();
            }
            $this->$method($event, $isNew);
        }
    }

    public function makeSnapshot()
    {
        $payloads = json_encode($this->getPayloads());
        $event    = new Event(get_class($this), $this->uuid, $this->playhead, $payloads);
        // TODO save snapshot !!
    }

    abstract public function getPayloads();

    /**
     * @param Event $event
     *
     * @throws ConcurrentAccessException
     */
    public function publish(Event $event)
    {
        if ($event->getPlayhead() > 0) {
            // ici on compare le playhead
            // si playhead == $event->getPlayhead() => conflit
            // throw new ConcurrentAccessException()
            $currentPlayhead = $this->eventStore->getCurrentPlayHead($this->uuid);
            if ($currentPlayhead === $event->getPlayhead()) {
                throw new ConcurrentAccessException();
            }
        }
        $this->apply($event);

        $this->eventStore->saveEvent($event, $this);

        $this->eventBus->dispatch($event, $this);
    }

    /**
     * @return int
     */
    public function getPlayhead()
    {
        return $this->playhead;
    }

    /**
     * @return string
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * @param EventStoreInterface $eventStore
     *
     * @return $this
     */
    public function setEventStore(EventStoreInterface $eventStore)
    {
        $this->eventStore = $eventStore;

        return $this;
    }

    /**
     * @param EventBus $eventBus
     *
     * @return $this
     */
    public function setEventBus(EventBus $eventBus)
    {
        $this->eventBus = $eventBus;

        return $this;
    }

    /**
     * @param LoggerInterface $logger
     *
     * @return $this
     */
    public function setLogger(LoggerInterface $logger = null)
    {
        $this->logger = $logger;

        return $this;
    }

    /**
     * @param string $eventClassname
     * @param array $payloads
     *
     * @return Event mixed
     */
    protected function createEvent($eventClassname, $payloads)
    {
        $this->playhead += 1;

        return new $eventClassname(self::class, $this->uuid, $this->playhead, $payloads);
    }


}