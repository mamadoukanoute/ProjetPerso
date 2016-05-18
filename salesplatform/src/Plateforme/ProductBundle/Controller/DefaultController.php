<?php

namespace Plateforme\ProductBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('PlateformeProductBundle:Default:index.html.twig');
    }
}
