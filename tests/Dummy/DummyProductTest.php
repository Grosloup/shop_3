<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 12/01/17
 * Time: 13:12
 */

namespace Tests\Dummy;


use Lib\CQRS\EventBus;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Tests\FixturesAwareTestCase;

class DummyProductTest extends FixturesAwareTestCase
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function setUp()
    {
        parent::setUp();

        $this->container = self::$kernel->getContainer();
    }

    /** @test */
    public function canTest()
    {
        $this->assertTrue(true);
    }

    /** @test */
    public function itCanCreateProduct()
    {
        $uuid = "222aa2a2-40ef-4c16-9811-94723942c995";
        $eb   = new EventBus();
        $es   = $this->container->get("cqrs.event_store");

        $command = new CreateProductCommand(
            $uuid,
            "Dummy product",
            39.9
        );

        $handler = new CreateProductCommandHandler($es, $eb);
        //$handler->setLogger($this->container->get('logger'));

        $handler->handle($command);

        $currentPlayhead = $es->getCurrentPlayHead($uuid);

        $this->assertEquals(0, $currentPlayhead);
    }

    /** @test */
    public function itCanChangeName()
    {
        $uuid = "222aa2a2-40ef-4c16-9811-94723942c995";
        $eb   = $this->container->get('cqrs.event_bus');
        $es   = $this->container->get("cqrs.event_store");
        $this->createProduct($uuid, $es, $eb);

        $command = new ChangeNameCommand($uuid, "Dummy product for test");
        $handler = new ChangeNameCommandHandler($es, $eb);

        $handler->handle($command);

        ///////////////////
        $p = Product::loadFromStream($es->getEventStream($command->getUuid()));
        $this->assertInstanceOf(Product::class, $p);
        ///////////////////

        $currentPlayhead = $es->getCurrentPlayHead($uuid);

        $this->assertEquals(1, $currentPlayhead);
    }

    private function createProduct($uuid, $es, $eb)
    {
        $command = new CreateProductCommand(
            $uuid,
            "Dummy product",
            39.9
        );
        $handler = new CreateProductCommandHandler($es, $eb);
        $handler->handle($command);
    }
}