<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 12/01/17
 * Time: 20:45
 */

namespace Shop\BackendBundle\Aggregate\Product;


use Doctrine\ORM\EntityManager;
use Lib\CQRS\AggregateInterface;
use Lib\CQRS\Event;
use Lib\CQRS\HookInterface;
use Shop\BackendBundle\Aggregate\ProductAggregate;
use Shop\BackendBundle\Entity\Product;

class ProductDoctrineHook implements HookInterface
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function save(Event $event, AggregateInterface $aggregate)
    {
        $product = $this->map(new Product(), $aggregate);
        $this->entityManager->persist($product);
        $this->entityManager->flush();
    }

    private function map(Product $entity, ProductAggregate $aggregate, $isUpdate = false)
    {
        $methods = preg_grep('/^set/', get_class_methods($entity));
        foreach ($methods as $method) {
            if ($method == "setCreatedAt" && $isUpdate) {
                continue;
            }
            $m = str_replace("set", "get", $method);
            if (method_exists($aggregate, $m)) {
                $entity->$method($aggregate->$m());
            }
        }
        $entity
            ->setPrice($aggregate->getCost()->getPrice())
            ->setMeasure($aggregate->getCost()->getMeasure())
            ->setUnit($aggregate->getCost()->getUnit())
            ->setCurrency($aggregate->getCost()->getCurrency())
            ->setTax($aggregate->getCost()->getTax());

        return $entity;
    }

    public function update(Event $event, AggregateInterface $aggregate)
    {
        $product = $this->getProduct($aggregate);
        if ($product) {
            $product = $this->map($product, $aggregate, true);
            $this->entityManager->persist($product);
            $this->entityManager->flush();
        }
    }

    private function getProduct(AggregateInterface $aggregate)
    {
        $repo = $this->entityManager->getRepository(Product::class);

        return $repo->findOneByUuid($aggregate->getUuid());
    }

    public function delete(Event $event, AggregateInterface $aggregate)
    {
        if (null != $product = $this->getProduct($aggregate)) {
            $product = $this->map($product, $aggregate);
            $this->entityManager->remove($product);
            $this->entityManager->flush();
        }
    }
}