<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 10/01/17
 * Time: 23:18
 */

namespace Lib\CQRS;


use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;

abstract class CommandHandlerAbstract implements
    CommandHandlerInterface,
    LoggerAwareInterface
{
    /**
     * @var EventStoreInterface
     */
    protected $eventStore;
    /**
     * @var LoggerInterface
     */
    protected $logger;
    /**
     * @var EventBus
     */
    protected $eventBus;

    public function __construct(
        EventStoreInterface $eventStore,
        EventBus $eventBus
    ) {
        $this->eventStore = $eventStore;
        $this->eventBus   = $eventBus;
    }

    abstract public function handle(CommandInterface $command);

    public function getName()
    {
        $fqn   = get_class($this);
        $parts = explode("\\", $fqn);

        return end($parts);
    }

    /**
     * Sets a logger instance on the object.
     *
     * @param LoggerInterface $logger
     *
     * @return void
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
}