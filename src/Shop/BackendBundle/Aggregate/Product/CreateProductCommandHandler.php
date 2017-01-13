<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 12/01/17
 * Time: 12:57
 */

namespace Shop\BackendBundle\Aggregate\Product;


use Lib\CQRS\CommandHandlerAbstract;
use Lib\CQRS\CommandInterface;
use Shop\BackendBundle\Aggregate\ProductAggregate;

class CreateProductCommandHandler extends CommandHandlerAbstract
{


    /**
     * @param CommandInterface|CreateProductCommand $command
     *
     * @throws \Exception
     */
    public function handle(CommandInterface $command)
    {
        if ($command->getName() == null) {
            throw new \Exception("You must provide a name for the product");
        }
        if ($command->getCost()->getPrice() == null) {
            throw new \Exception("You must provide a price for the product");
        }
        if ($command->getDescription() == null) {
            throw new \Exception("You must provide a description for the product");
        }
        /** @var ProductAggregate $product */
        $product = ProductAggregate::loadFromStream();

        $product->setLogger($this->logger)
                ->setEventBus($this->eventBus)
                ->setEventStore($this->eventStore);

        $product->create(
            $command->getUuid(),
            [
                "name"        => $command->getName(),
                "reference"   => $command->getReference(),
                "cost"        => $command->getCost(),
                "description" => $command->getDescription(),
            ]

        );


    }
}