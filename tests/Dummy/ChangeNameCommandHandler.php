<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 12/01/17
 * Time: 13:41
 */

namespace Tests\Dummy;


use Lib\CQRS\CommandHandlerAbstract;
use Lib\CQRS\CommandInterface;

class ChangeNameCommandHandler extends CommandHandlerAbstract
{

    /**
     * @param CommandInterface|ChangeNameCommand $command
     */
    public function handle(CommandInterface $command)
    {
        $stream = $this->eventStore->getEventStream($command->getUuid());
        /** @var Product $product */
        $product = Product::loadFromStream($stream);

        $product->setLogger($this->logger)
                ->setEventBus($this->eventBus)
                ->setEventStore($this->eventStore);

        $product->changeName($command->getName());
    }
}