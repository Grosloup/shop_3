<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 12/01/17
 * Time: 12:42
 */

namespace Tests;


use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Symfony\Bridge\Doctrine\DataFixtures\ContainerAwareLoader;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class FixturesAwareTestCase extends KernelTestCase
{
    /**
     * @var ORMPurger
     */
    protected $purger;
    /**
     * @var ORMExecutor
     */
    private $fixtureExecutor;
    /**
     * @var ContainerAwareLoader
     */
    private $fixtureLoader;

    public function setUp()
    {
        self::bootKernel();
        $this->purger = new ORMPurger(self::$kernel->getContainer()->get('doctrine')->getManager());
        $this->purger->purge();
    }

    /**
     * Adds a new fixture to be loaded.
     *
     * @param FixtureInterface $fixture
     */
    protected function addFixture(FixtureInterface $fixture)
    {
        $this->getFixtureLoader()->addFixture($fixture);
    }

    /**
     * @return ContainerAwareLoader
     */
    private function getFixtureLoader()
    {
        if ( ! $this->fixtureLoader) {
            $this->fixtureLoader = new ContainerAwareLoader(self::$kernel->getContainer());
        }

        return $this->fixtureLoader;
    }

    /**
     * Executes all the fixtures that have been loaded so far.
     */
    protected function executeFixtures()
    {
        $this->getFixtureExecutor()->execute($this->getFixtureLoader()->getFixtures());
    }

    /**
     * @return ORMExecutor
     */
    private function getFixtureExecutor()
    {
        if ( ! $this->fixtureExecutor) {
            /** @var \Doctrine\ORM\EntityManager $entityManager */
            $entityManager         = self::$kernel->getContainer()->get('doctrine')->getManager();
            $this->fixtureExecutor = new ORMExecutor($entityManager, new ORMPurger($entityManager));
        }

        return $this->fixtureExecutor;
    }
}