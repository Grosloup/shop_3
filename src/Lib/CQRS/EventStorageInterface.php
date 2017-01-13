<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 10/01/17
 * Time: 20:37
 */

namespace Lib\CQRS;


interface EventStorageInterface
{
    public function getStream($string);

    public function getPlayhead($string);

    public function saveEvent(Event $event);
}