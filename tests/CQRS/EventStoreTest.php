<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 10/01/17
 * Time: 20:21
 */

namespace Tests\Lib\CQRS;


use Lib\CQRS\EventStorageInterface;
use Lib\CQRS\EventStore;
use Lib\CQRS\Exception\InvalidUuidException;
use Psr\Log\LoggerAwareInterface;

class EventStoreTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var EventStore
     */
    protected $eventStore;

    public function setUp()
    {
        $eventStorage     = $this->createMock(EventStorageInterface::class);
        $this->eventStore = new EventStore($eventStorage);
    }

    /** @test */
    public function itIsLoggerAware()
    {
        $this->assertInstanceOf(LoggerAwareInterface::class, $this->eventStore);
    }

    /** @test */
    public function itIsEventStoreInterface()
    {
        $this->assertInstanceOf(\Lib\CQRS\EventStoreInterface::class, $this->eventStore);
    }

    /** @test */
    public function itThrowExceptionIfUuidIsNotAStringInGetEventStream()
    {
        $this->expectException(InvalidUuidException::class);
        $this->eventStore->getEventStream([]);

    }

    /** @test */
    public function itThrowExceptionIfUuidIsNotAStringInGetCurrentPlayHead()
    {
        $this->expectException(InvalidUuidException::class);
        $this->eventStore->getCurrentPlayHead([]);

    }
}