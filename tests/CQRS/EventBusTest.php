<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 10/01/17
 * Time: 16:03
 */

namespace Tests\Lib\CQRS;


use Lib\CQRS\AggregateInterface;
use Lib\CQRS\Event;
use Lib\CQRS\EventBus;
use Psr\Log\LoggerAwareInterface;

class EventBusTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var EventBus
     */
    protected $eventBus;

    public function setUp()
    {
        $this->eventBus = new EventBus();
    }

    /** @test */
    public function itIsLoggerAware()
    {
        $this->assertInstanceOf(LoggerAwareInterface::class, $this->eventBus);
    }

    /** @test */
    public function itCanRegisterListener()
    {
        $this->eventBus->registerListener(
            "an_event",
            function ($event) {
            }
        );

        $this->assertCount(1, $this->eventBus->getListeners());
    }

    /**
     * @test
     * @expectedException \Lib\CQRS\Exception\InvalidEventNameException
     * @expectedExceptionMessage The event name must be a not empty string
     */
    public function itShouldThrowAnInvalidEventNameExceptionIfEventnameIsNotAString()
    {
        $this->eventBus->registerListener(
            1,
            function ($event) {
            }
        );
    }

    /**
     * @test
     * @expectedException \Lib\CQRS\Exception\InvalidEventNameException
     * @expectedExceptionMessage The event name must be a not empty string
     */
    public function itShouldThrowAnInvalidEventNameExceptionIfEventnameIsANullString()
    {
        $this->eventBus->registerListener(
            "",
            function ($event) {
            }
        );
    }

    /**
     * @test
     * @expectedException \Lib\CQRS\Exception\InvalidListenerException
     * @expectedExceptionMessage The second argument must be callable
     */
    public function itShouldThrowAnInvalidListenerExceptionIfCallableIsNotCallable()
    {
        $this->eventBus->registerListener("an_event", "IamNotCallable");
    }

    /** @test */
    public function itCanRegisterTwoListenersUnderOneEventName()
    {
        $this->eventBus->registerListener(
            "an_event",
            function ($event) {
            }
        );
        $this->eventBus->registerListener(
            "an_event",
            function ($event) {
            }
        );

        $listeners = $this->eventBus->getListeners();
        $this->assertCount(2, $listeners["an_event"]);
    }

    /** @test */
    public function itCanRegisterMultipleListenersUnderMultipleEventName()
    {
        $this->eventBus->registerListener(
            "an_event",
            function ($event) {
            }
        );
        $this->eventBus->registerListener(
            "an_event",
            function ($event) {
            }
        );
        $this->eventBus->registerListener(
            "an_event",
            function ($event) {
            }
        );

        $this->eventBus->registerListener(
            "another_event",
            function ($event) {
            }
        );
        $this->eventBus->registerListener(
            "another_event",
            function ($event) {
            }
        );
        $this->eventBus->registerListener(
            "another_event",
            function ($event) {
            }
        );

        $listeners = $this->eventBus->getListeners();

        $this->assertCount(3, $listeners["an_event"]);
        $this->assertCount(3, $listeners["another_event"]);
    }

    /** @test */
    public function itCanDispatchEvent()
    {
        $event = $this
            ->getMockBuilder(Event::class)
            ->disableOriginalConstructor()
            ->setMethods(['getName'])
            ->getMock();
        $event->method('getName')->willReturn(Event::class);
        $aggregate = $this->createMock(AggregateInterface::class);

        $listener = $this->getMockBuilder(\stdClass::class)->setMethods(['foo'])->getMock();
        $listener->expects($this->once())->method('foo')->with($this->equalTo($event), $this->equalTo($aggregate));
        $listener2 = $this->getMockBuilder(\stdClass::class)->setMethods(['bar'])->getMock();
        $listener2->expects($this->once())->method('bar')->with($this->equalTo($event), $this->equalTo($aggregate));

        $this->eventBus->registerListener(Event::class, [$listener, 'foo']);
        $this->eventBus->registerListener(Event::class, [$listener2, 'bar']);

        $this->eventBus->dispatch($event, $aggregate);
    }
}