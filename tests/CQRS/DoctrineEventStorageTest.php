<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 12/01/17
 * Time: 11:33
 */

namespace Tests\Lib\CQRS;


use Lib\CQRS\DoctrineEventStorage;
use Lib\CQRS\Event;
use Tests\DataFixtures\ORM\LoadEventStoreRows;
use Shop\BackendBundle\Entity\EventStoreRow;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Tests\FixturesAwareTestCase;

class DoctrineEventStorageTest extends FixturesAwareTestCase
{


    private $container;
    /**
     * @var DoctrineEventStorage
     */
    private $des;

    private $em;

    public function setUp()
    {
        parent::setUp();

        $this->container = self::$kernel->getContainer();

        $em = $this->container->get('doctrine.orm.default_entity_manager');

        $this->des =
            new DoctrineEventStorage(
                $em,
                EventStoreRow::class
            );
    }

    /** @test */
    public function canTest()
    {
        $this->assertEquals("test", self::$kernel->getEnvironment());
        $this->assertInstanceOf(ContainerInterface::class, $this->container);
    }

    /** @test */
    public function itCanGetEmptyEventStream()
    {
        $stream = $this->des->getStream("111");
        $this->assertEquals([], $stream);
        $this->assertThat($stream, $this->isType("array"));
    }

    /** @test */
    public function itCanGetEventStream()
    {
        $this->addFixture(new LoadEventStoreRows("579ca0b2-40ef-4c16-9811-94723942c995"));
        $this->executeFixtures();
        $stream = $this->des->getStream("579ca0b2-40ef-4c16-9811-94723942c995");
        $this->assertEquals(5, count($stream));
    }

    /** @test */
    public function ItCanGetPlayhead()
    {
        $this->addFixture(new LoadEventStoreRows("579ca0b2-40ef-4c16-9811-94723942c995"));
        $this->executeFixtures();
        $playhead = $this->des->getPlayhead("579ca0b2-40ef-4c16-9811-94723942c995");
        $this->assertEquals(5, $playhead);
    }

    /** @test */
    public function ItCanSaveAnEvent()
    {
        $uuid = "111aa1a1-40ef-4c16-9811-94723942c995";
        $evt  = new Event("agg2", $uuid, 1, ["incr" => 1]);
        $this->des->saveEvent($evt);

        $stream = $this->des->getStream($uuid);
        $this->assertEquals(1, count($stream));
        $playhead = $this->des->getPlayhead($uuid);
        $this->assertEquals(1, $playhead);
    }


}