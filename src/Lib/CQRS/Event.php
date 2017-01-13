<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 10/01/17
 * Time: 17:39
 */

namespace Lib\CQRS;


class Event implements EventInterface
{

    /**
     * @var string
     */
    private $aggregateType;
    /**
     * @var string
     */
    private $aggregateUuid;
    /**
     * @var string
     */
    private $playhead;
    /**
     * @var string
     */
    private $payloads;
    /**
     * @var \DateTime
     */
    private $createdAt;

    public function __construct(
        $aggregateType,
        $aggregateUuid,
        $playhead,
        $payloads
    ) {

        $this->aggregateType = $aggregateType;
        $this->aggregateUuid = $aggregateUuid;
        $this->playhead      = $playhead;
        $this->payloads      = $payloads;
        $this->createdAt     = new \DateTime('now');
    }

    public function toArray()
    {
        $thisAsArray = [
            $this->getName(),
            $this->getAggregateType(),
            $this->getAggregateUuid(),
            json_encode($this->getPayloads()),
            $this->getPlayhead(),
            $this->getCreatedAt()->format("Y-m-d H:i:s"),
        ];

        return $thisAsArray;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return get_class($this);
    }

    /**
     * @return string
     */
    public function getAggregateType()
    {
        return $this->aggregateType;
    }

    /**
     * @return string
     */
    public function getAggregateUuid()
    {
        return $this->aggregateUuid;
    }

    /**
     * @return string
     */
    public function getPayloads()
    {
        return $this->payloads;
    }

    /**
     * @return string
     */
    public function getPlayhead()
    {
        return $this->playhead;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function find($payload, $default = null)
    {
        if (array_key_exists($payload, $this->payloads)) {
            return $this->payloads[$payload];
        }

        return $default;
    }


}