<?php

namespace Shop\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EventStoreRow
 *
 * @ORM\Table(name="event_store_rows")
 * @ORM\Entity(repositoryClass="Shop\BackendBundle\Repository\EventStoreRowRepository")
 */
class EventStoreRow
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="aggregate_type", type="string", length=255)
     */
    private $aggregateType;

    /**
     * @var string
     *
     * @ORM\Column(name="aggregate_uuid", type="string", length=255)
     */
    private $aggregateUuid;

    /**
     * @var int
     *
     * @ORM\Column(name="playhead", type="integer")
     */
    private $playhead;

    /**
     * @var string
     *
     * @ORM\Column(name="payloads", type="text")
     */
    private $payloads;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return EventStoreRow
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get aggregateType
     *
     * @return string
     */
    public function getAggregateType()
    {
        return $this->aggregateType;
    }

    /**
     * Set aggregateType
     *
     * @param string $aggregateType
     *
     * @return EventStoreRow
     */
    public function setAggregateType($aggregateType)
    {
        $this->aggregateType = $aggregateType;

        return $this;
    }

    /**
     * Get aggregateUuid
     *
     * @return string
     */
    public function getAggregateUuid()
    {
        return $this->aggregateUuid;
    }

    /**
     * Set aggregateUuid
     *
     * @param string $aggregateUuid
     *
     * @return EventStoreRow
     */
    public function setAggregateUuid($aggregateUuid)
    {
        $this->aggregateUuid = $aggregateUuid;

        return $this;
    }

    /**
     * Get playhead
     *
     * @return int
     */
    public function getPlayhead()
    {
        return $this->playhead;
    }

    /**
     * Set playhead
     *
     * @param integer $playhead
     *
     * @return EventStoreRow
     */
    public function setPlayhead($playhead)
    {
        $this->playhead = $playhead;

        return $this;
    }

    /**
     * Get payloads
     *
     * @return string
     */
    public function getPayloads()
    {
        return $this->payloads;
    }

    /**
     * Set payloads
     *
     * @param string $payloads
     *
     * @return EventStoreRow
     */
    public function setPayloads($payloads)
    {
        $this->payloads = $payloads;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return EventStoreRow
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}

