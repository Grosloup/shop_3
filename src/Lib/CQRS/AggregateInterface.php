<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 10/01/17
 * Time: 18:16
 */

namespace Lib\CQRS;


interface AggregateInterface
{
    public static function loadFromStream($stream = []);

    public function publish(Event $event);

    public function apply(Event $event, $isNew = true);

    public function setEventStore(EventStoreInterface $eventStore);

    public function setEventBus(EventBus $eventBus);

    public function getUuid();

    public function makeSnapshotEvent();
}