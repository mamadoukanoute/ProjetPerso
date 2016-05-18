<?php

namespace Plateforme\MenuSellerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MenuController extends Controller
{
	public function homeAction()
	{
		return $this->render('PlateformeMenuSellerBundle:Menu:home.html.twig');
	}

	public function home_ProfileAction()
	{
		return $this->render('PlateformeMenuSellerBundle:Profile:home.html.twig');
	}

public function home_searchAction()
    {

        return $this->render('PlateformeMenuSellerBundle:Menu:search.html.twig');
    }

 public function searchbyTypeformAction()
    {

		$repository = $this->getDoctrine()
                  			 ->getManager();
    		$repository2=    $repository ->getRepository('PlateformeProductBundle:Type');
		$Type = $repository2->findAll();

        return $this->render('PlateformeMenuSellerBundle:Menu:searchbytypeform.html.twig',array('Type'=>$Type ));
    }

 public function searchbyTypeAction()
    {



$typeid=$_POST['catid'];

		 $repository = $this->getDoctrine()
                   ->getManager();
                      $user = $this->get('security.token_storage')->getToken()->getUser();
		$userid= $user->getId();
$query = $repository->createQuery("SELECT a FROM PlateformeProductBundle:Products a WHERE a.typeid='$typeid' AND a.fournid='$userid' ");
$listProducts = $query->getResult();
$role="Seller";
 return $this->render('PlateformeMenuSellerBundle:Menu:view.html.twig',array('listProducts'=>$listProducts,'role'=>$role));

    }




 public function searchbyNameformAction()
    {

		$repository = $this->getDoctrine()
                  			 ->getManager();
    		$repository2=    $repository ->getRepository('PlateformeProductBundle:Type');
		$Type = $repository2->findAll();

        return $this->render('PlateformeMenuSellerBundle:Menu:searchbyNameform.html.twig',array('Type'=>$Type ));
    }

 public function searchbyNameAction()
    {



$nom=$_POST['nom'];

		 $repository = $this->getDoctrine()
                   ->getManager();
             $user = $this->get('security.token_storage')->getToken()->getUser();
		$userid= $user->getId();
$query = $repository->createQuery("SELECT a FROM PlateformeProductBundle:Products a WHERE a.name LIKE '%$nom%' AND a.fournid='$userid' ");
$listProducts = $query->getResult();

 return $this->render('PlateformeMenuSellerBundle:Menu:view.html.twig',array('listProducts'=>$listProducts,));

    }




}
