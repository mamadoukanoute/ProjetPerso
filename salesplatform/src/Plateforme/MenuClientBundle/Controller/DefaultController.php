<?php

namespace Plateforme\MenuClientBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('PlateformeMenuClientBundle:Default:index.html.twig');
    }
}
