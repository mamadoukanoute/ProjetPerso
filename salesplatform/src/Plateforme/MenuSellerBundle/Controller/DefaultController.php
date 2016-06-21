<?php

namespace Plateforme\MenuSellerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('PlateformeMenuSellerBundle:Default:index.html.twig');
    }
}
