<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 12/01/17
 * Time: 18:30
 */

namespace Shop\BackendBundle\Aggregate\Product;


use Lib\CQRS\CommandHandlerAbstract;
use Lib\CQRS\CommandInterface;
use Shop\BackendBundle\Aggregate\ProductAggregate;

class ChangePriceCommandHandler extends CommandHandlerAbstract
{
    /**
     * @param CommandInterface|ChangePriceCommand $command
     */
    public function handle(CommandInterface $command)
    {
        $stream = $this->eventStore->getEventStream($command->getUuid());
        /** @var ProductAggregate $product */
        $product = ProductAggregate::loadFromStream($stream);

        $product->setLogger($this->logger)
                ->setEventBus($this->eventBus)
                ->setEventStore($this->eventStore);

        $product->changePrice(["cost" => $command->getCost()]);
    }
}