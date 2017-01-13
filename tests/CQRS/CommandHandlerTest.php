<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 11/01/17
 * Time: 23:48
 */

namespace Tests\Lib\CQRS;


use Lib\CQRS\CommandHandlerAbstract;
use Lib\CQRS\CommandInterface;
use Lib\CQRS\EventBus;
use Lib\CQRS\EventStore;
use Lib\CQRS\EventStoreInterface;

class FakeHandler extends CommandHandlerAbstract
{

    public function handle(CommandInterface $command)
    {
    }
}

class CommandHandlerTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function itWilReturnIsName()
    {
        $cdhd = new FakeHandler($this->createMock(EventStore::class), $this->createMock(EventBus::class));

        $this->assertEquals('FakeHandler', $cdhd->getName());
    }
}