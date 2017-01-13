<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 12/01/17
 * Time: 12:57
 */

namespace Tests\Dummy;


use Lib\CQRS\CommandHandlerAbstract;
use Lib\CQRS\CommandInterface;

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
        if ($command->getPrice() == null) {
            throw new \Exception("You must provide a price for the product");
        }

        /** @var Product $product */
        $product = Product::loadFromStream();

        $product->setLogger($this->logger)
                ->setEventBus($this->eventBus)
                ->setEventStore($this->eventStore);

        $product->create(
            $command->getUuid(),
            $command->getName(),
            $command->getPrice()
        );


    }
}