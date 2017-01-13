<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 12/01/17
 * Time: 20:44
 */

namespace Lib\CQRS;


interface HookInterface
{
    public function save(Event $event, AggregateInterface $aggregate);

    public function update(Event $event, AggregateInterface $aggregate);

    public function delete(Event $event, AggregateInterface $aggregate);
}