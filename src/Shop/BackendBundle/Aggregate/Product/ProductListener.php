<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 12/01/17
 * Time: 18:39
 */

namespace Shop\BackendBundle\Aggregate\Product;


use Lib\CQRS\AggregateInterface;
use Lib\CQRS\Event;
use Lib\CQRS\Hookable;
use Lib\CQRS\HookInterface;

class ProductListener
{
    use Hookable;

    public function onProductCreated(Event $event, AggregateInterface $aggregate)
    {
        foreach ($this->hooks as $hook) {
            /** @var HookInterface $hook */
            $hook->save($event, $aggregate);
        }
    }

    public function onProductUpdated(Event $event, AggregateInterface $aggregate)
    {
        foreach ($this->hooks as $hook) {
            /** @var HookInterface $hook */
            $hook->update($event, $aggregate);
        }
    }
}