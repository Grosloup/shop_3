<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 12/01/17
 * Time: 00:31
 */

namespace Lib\CQRS;


use Doctrine\ORM\EntityManager;
use Shop\BackendBundle\Entity\EventStoreRow;

class DoctrineEventStorage implements EventStorageInterface
{
    /**
     * @var EntityManager
     */
    protected $entityManager;
    /**
     * @var string
     */
    protected $entityClass;
    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    protected $repository;

    public function __construct(EntityManager $entityManager, $entityClass = "")
    {
        $this->entityManager = $entityManager;
        $this->entityClass   = $entityClass;
        $this->repository    =
            $this->entityManager->getRepository($this->entityClass);
    }

    public function getStream($string)
    {
        $qb = $this->repository->createQueryBuilder("esr");
        $qb->where("esr.aggregateUuid = :uuid")->setParameter(":uuid", $string);

        //$qb->orderBy("esr.playhead", "DESC");
        return $qb->getQuery()->getArrayResult();
    }

    public function getPlayhead($string)
    {
        $qb = $this->repository->createQueryBuilder("esr")->select("esr.playhead");
        $qb->where("esr.aggregateUuid = :uuid")->setParameter(":uuid", $string);
        $qb->orderBy("esr.playhead", "DESC")->setMaxResults(1);

        return $qb->getQuery()->getSingleScalarResult();
    }

    public function saveEvent(Event $event)
    {
        $esr = new EventStoreRow();
        $esr->setName($event->getName());
        $esr->setAggregateUuid($event->getAggregateUuid());
        $esr->setAggregateType($event->getAggregateType());
        $esr->setPayloads(json_encode($event->getPayloads()));
        $esr->setPlayhead((int)$event->getPlayhead());
        $esr->setCreatedAt($event->getCreatedAt());
        $this->entityManager->persist($esr);
        $this->entityManager->flush();
    }

    public function getStreamFromPlayhead($uuid, $playhead)
    {
        // TODO: Implement getStreamFromPlayhead() method.
    }
}