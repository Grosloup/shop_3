<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 12/01/17
 * Time: 12:08
 */

namespace Tests\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;
use Shop\BackendBundle\Entity\EventStoreRow;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadEventStoreRows extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;
    /**
     * @var string
     */
    private $uuid;

    public function __construct($uuid = "")
    {

        $this->uuid = $uuid;
    }

    public function load(ObjectManager $manager)
    {
        //$uuid = Uuid::uuid4()->toString();

        $uuid = $this->uuid ? $this->uuid : Uuid::uuid4()->toString();
        for ($i = 0; $i < 5; $i++) {

            $esr = new EventStoreRow();
            $esr
                ->setName("event1")
                ->setAggregateUuid($uuid)
                ->setAggregateType("aggregate1")
                ->setPayloads(json_encode(["incr" => 1]))
                ->setCreatedAt(new \DateTime())
                ->setPlayhead($i + 1);
            $manager->persist($esr);
        }
        $manager->flush();
    }


    public function getOrder()
    {
        return 1;
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}