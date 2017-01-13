<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 11/01/17
 * Time: 23:58
 */

namespace Tests\Lib\CQRS;


use Lib\CQRS\Event;
use Lib\CQRS\EventInterface;

class EventTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function itImplementsEventInterface()
    {
        $event = new Event("a", "b", 1, []);
        $this->assertInstanceOf(EventInterface::class, $event);
    }

    /** @test */
    public function itCanBeTransformInArray()
    {
        $event = new Event("a", "b", 1, []);
        $array = $event->toArray();

        $this->assertThat($array, $this->isType('array'));
    }

    /** @test */
    public function createdAtIsADateTime()
    {
        $event = new Event("a", "b", 1, []);
        $dt    = $event->getCreatedAt();
        $this->assertInstanceOf(\DateTime::class, $dt);
    }
}