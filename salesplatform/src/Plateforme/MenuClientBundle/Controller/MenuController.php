<?php

namespace Plateforme\MenuClientBundle\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Plateforme\ProduitBundle\Entity\basket;
class MenuController extends Controller
{

	/*public function nbrebasket($userid){

return $i;



}*/


	public function homeAction()
	{
		$user = $this->get('security.token_storage')->getToken()->getUser();
		$userid= $user->getId();
		$i=0;
		$repository = $this->getDoctrine()
				->getManager();
				$repository2=    $repository ->getRepository('PlateformeProductBundle:Basket');
				$listebasket = $repository2->findByUserid($userid);

				foreach($listebasket as $basket){
					$i=$i+$basket->getQte();

				};
				$session=new Session();
				$session->set('basket',$i);


				return $this->render('PlateformeMenuClientBundle:Menu:home.html.twig',array('basket'=>$i,'user'=>$user));
	}



	public function home_ProfileAction()
	{
		return $this->render('PlateformeMenuClientBundle:Profile:home.html.twig');
	}


    public function home_searchAction()
    {

        return $this->render('PlateformeMenuClientBundle:Menu:search.html.twig');
    }

 public function searchbyTypeformAction()
    {

		$repository = $this->getDoctrine()
                  			 ->getManager();
    		$repository2=    $repository ->getRepository('PlateformeProductBundle:Type');
		$Type = $repository2->findAll();

        return $this->render('PlateformeMenuClientBundle:Menu:searchbytypeform.html.twig',array('Type'=>$Type ));
    }

 public function searchbyTypeAction()
    {



$typeid=$_POST['catid'];

		 $repository = $this->getDoctrine()
                   ->getManager();
    $repository2=    $repository ->getRepository('PlateformeProductBundle:Products');

$listProducts = $repository2->findByTypeid($typeid);
$role="client";
 return $this->render('PlateformeMenuClientBundle:Menu:view.html.twig',array('listProducts'=>$listProducts,'role'=>$role));

    }




 public function searchbyNameformAction()
    {

		$repository = $this->getDoctrine()
                  			 ->getManager();
    		$repository2=    $repository ->getRepository('PlateformeProductBundle:Type');
		$Type = $repository2->findAll();

        return $this->render('PlateformeMenuClientBundle:Menu:searchbyNameform.html.twig',array('Type'=>$Type ));
    }

 public function searchbyNameAction()
    {



$nom=$_POST['nom'];

		 $repository = $this->getDoctrine()
                   ->getManager();
$query = $repository->createQuery("SELECT a FROM PlateformeProductBundle:Products a WHERE a.name LIKE '%$nom%'   ");
$listProducts = $query->getResult();
 return $this->render('PlateformeMenuClientBundle:Menu:view.html.twig',array('listProducts'=>$listProducts,));

    }





}
