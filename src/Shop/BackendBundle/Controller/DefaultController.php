<?php

namespace Shop\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        dump($this->get("cqrs.event_bus"));

        return $this->render('ShopBackendBundle:Default:index.html.twig');
    }
}
