<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 10/01/17
 * Time: 20:28
 */

namespace Lib\CQRS;


interface EventStoreInterface
{
    public function getEventStream($uuid);

    public function getCurrentPlayHead($uuid);

    public function saveEvent(Event $event, AggregateInterface $aggregate);
}