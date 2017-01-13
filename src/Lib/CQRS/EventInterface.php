<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 10/01/17
 * Time: 20:46
 */

namespace Lib\CQRS;


interface EventInterface
{
    public function toArray();

    public function getAggregateType();

    public function getAggregateUuid();

    public function getPlayhead();

    public function getPayloads();

    public function getCreatedAt();

}