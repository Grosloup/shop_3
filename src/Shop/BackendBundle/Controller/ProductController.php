<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 12/01/17
 * Time: 21:43
 */

namespace Shop\BackendBundle\Controller;


use Lib\Factory\CostFactory;
use Lib\ValueObject\Cost;
use Ramsey\Uuid\Uuid;
use Shop\BackendBundle\Aggregate\Product\ChangeDescriptionCommand;
use Shop\BackendBundle\Aggregate\Product\ChangeNameCommand;
use Shop\BackendBundle\Aggregate\Product\ChangePriceCommand;
use Shop\BackendBundle\Aggregate\Product\CreateProductCommand;
use Shop\BackendBundle\Entity\Product;
use Shop\BackendBundle\Form\ProductForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends Controller
{
    public function indexAction()
    {
        $products = $this->getDoctrine()->getRepository(Product::class)->findAll();

        return $this->render("ShopBackendBundle:Product:index.html.twig", ["products" => $products]);
    }

    public function createAction(Request $request)
    {
        $product = new \Shop\BackendBundle\Model\Product();
        $form    = $this->createForm(ProductForm::class, $product);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $cost = new Cost($product->getPrice(), $product->getMeasure(), $product->getUnit(), 0.2, "EUR");
            $cd   = new CreateProductCommand(
                Uuid::uuid4()->toString(),
                $product->getName(),
                $cost,
                $product->getDescription(),
                $product->getReference()
            );
            $cb   = $this->get('cqrs.command_bus');
            $cb->dispatch($cd);

            return $this->redirectToRoute("shop_backend_products_homepage");
        }

        return $this->render("ShopBackendBundle:Product:create.html.twig", ["form" => $form->createView()]);
    }

    public function updateAction($uuid, Request $request)
    {
        $product = $this->getDoctrine()->getRepository(Product::class)->findOneBy(["uuid" => $uuid]);
        if ( ! $product) {
            throw $this->createNotFoundException();
        }
        $model = new \Shop\BackendBundle\Model\Product();
        if ( ! $request->isMethod("post")) {
            $model
                ->setName($product->getName())
                ->setReference($product->getReference())
                ->setDescription($product->getDescription())
                ->setPrice($product->getPrice())
                ->setMeasure($product->getMeasure())
                ->setUnit($product->getUnit());
        }
        $model->setTax($product->getTax())
              ->setCurrency($product->getCurrency());

        $form = $this->createForm(ProductForm::class, $model);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $productCost = CostFactory::create($product);
            $modelCost   = CostFactory::create($model);
            $cb          = $this->get('cqrs.command_bus');
            $cds         = [];
            if ($product->getName() != $model->getName()) {
                $cds[] = new ChangeNameCommand($product->getUuid(), $model->getName());
            }
            if ( ! $productCost->equal($modelCost)) {
                $cds[] = new ChangePriceCommand($product->getUuid(), $modelCost);
            }
            if ($product->getDescription() != $model->getDescription()) {
                $cds[] = new ChangeDescriptionCommand($product->getUuid(), $model->getDescription());
            }
            foreach ($cds as $cd) {
                $cb->dispatch($cd);
            }

            return $this->redirectToRoute("shop_backend_products_homepage");
        }

        return $this->render("ShopBackendBundle:Product:update.html.twig", ["form" => $form->createView()]);
    }
}