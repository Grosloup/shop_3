<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 10/01/17
 * Time: 23:26
 */

namespace Tests\Lib\CQRS;


use Lib\CQRS\CommandBus;
use Lib\CQRS\CommandBusInterface;
use Lib\CQRS\CommandHandlerAbstract;
use Lib\CQRS\CommandInterface;
use Psr\Log\LoggerAwareInterface;

class CommandBusTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CommandBus
     */
    protected $commandBus;

    public function setUp()
    {
        $this->commandBus = new CommandBus();
    }

    /** @test */
    public function itIsLoggerAware()
    {
        $this->assertInstanceOf(LoggerAwareInterface::class, $this->commandBus);
    }

    /** @test */
    public function itIsCommandBusInterface()
    {
        $this->assertInstanceOf(CommandBusInterface::class, $this->commandBus);
    }

    /** @test */
    public function itCanRegisterOneHandlerForOneCommand()
    {
        $cdhd = $this
            ->getMockBuilder(CommandHandlerAbstract::class)
            ->disableOriginalConstructor()
            ->setMethods(['getName'])
            ->getMockForAbstractClass();
        $cdhd->method('getName')->willReturn('MyCommandHandler');

        $this->commandBus->registerHandler($cdhd);
        $handlers = $this->commandBus->getHandlers();
        $this->assertCount(1, $handlers);
        $this->assertArrayHasKey('MyCommandHandler', $handlers);
    }

    /** @test */
    public function itCanDispatchCommand()
    {
        $cdhd = $this
            ->getMockBuilder(CommandHandlerAbstract::class)
            ->disableOriginalConstructor()
            ->setMethods(['getName', 'handle'])
            ->getMockForAbstractClass();
        $cdhd->method('getName')->willReturn('MyCommandHandler');
        $this->commandBus->registerHandler($cdhd);

        $cd = $this
            ->getMockBuilder(CommandInterface::class)
            ->disableOriginalConstructor()
            ->setMethods(['getName'])
            ->getMockForAbstractClass();
        $cd->method('getHandlerName')->willReturn('MyCommandHandler');
        $cdhd->expects($this->once())->method('handle')->with($this->equalTo($cd));
        $this->commandBus->dispatch($cd);
    }

    /** @test */
    public function itCanNotDispatchCommand()
    {
        $cdhd = $this
            ->getMockBuilder(CommandHandlerAbstract::class)
            ->disableOriginalConstructor()
            ->setMethods(['getName', 'handle'])
            ->getMockForAbstractClass();
        $cdhd->method('getName')->willReturn('MyCommandHandler');
        $this->commandBus->registerHandler($cdhd);
        $cd = $this
            ->getMockBuilder(CommandInterface::class)
            ->disableOriginalConstructor()
            ->setMethods(['getName'])
            ->getMockForAbstractClass();
        $cd->method('getHandlerName')->willReturn('CommandHandler');
        $cdhd->expects($this->never())->method('handle');

        $result = $this->commandBus->dispatch($cd);
        $this->assertFalse($result);
    }
}