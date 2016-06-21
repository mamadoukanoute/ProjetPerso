<?php

namespace Plateforme\ProductBundle\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Plateforme\ProductBundle\Entity\basket;
use Plateforme\ProductBundle\Form\BasketType;
use Plateforme\ProductBundle\Form\basketTest;
use Symfony\Component\HttpFoundation\Response;

class BasketController extends Controller
{

	public $v=0;



	public function homeAction()
	{
		return $this->render('PlateformeVieetudianteBundle:Annonces:accueil.html.twig');
	}




	/*********************Afficher,Modifier,Supprimer le basket************************************************************************/

	public function displayBasketAction(Request $request)
	{

		$user = $this->get('security.token_storage')->getToken()->getUser();
		$userid= $user->getId();
		$repository = $this->getDoctrine()
				->getManager();
				$repository2=    $repository ->getRepository('PlateformeProductBundle:Basket');
				// $listeProducts=    $repository ->getRepository('PlateformeProductBundle:Products');
				$listBasket = $repository2->findByUserid($userid);
				$tableau=array();
				foreach( $listBasket as $cmd){
					$tableau[$cmd->getProdid()]=$this->get_Name($cmd->getProdid());
				} 

				//$listBasket = $repository2->findByUserid($userid);
				return $this->render('PlateformeProductBundle:Basket:show.html.twig',array('listBasket'=>$listBasket,'tableau'=>$tableau));

	}

	//else return $this->render('PlateformeProductBundle:basket:afficher.html.twig',array('listBasket'=>$listBasket,'listeProducts'=>$listeProducts,'arrayListe' =>$responseArray ));



	/******************************************Modifier le basket****************************************************/

	public function updateBasketAction($pid,Request $request)
	{

		$repository = $this->getDoctrine()
				->getManager();
				$repository2=    $repository ->getRepository('PlateformeProductBundle:Basket');
				$listBasket = $repository2->findOneByPid($pid);
				$basket=$listBasket;
				$session=new Session();
				$quantiteold=$basket->getQte();
				$quantitenew;
				$resultatqte;
				$quantitesession=intval($session->get('basket'));
				//echo $quantitesession;
				$qtefinale;
				//$basket=$listBasket;
				$form = $this->createForm( BasketType::class, $basket);
				if ($request->getMethod() == 'POST'){
					$form->handleRequest($request);
					if($form->isValid()) {
						$quantitenew=$basket->getQte();
						$resultatqte=$quantitenew-$quantiteold;
						$qtefinale=$quantitesession+$resultatqte;
						$session->set('basket',$qtefinale);
						// On l'enregistre notre objet $article dans la base de
						/*$em = $this->getDoctrine()->getManager();*/
						//s$repository->refresh($basket);
						$repository ->flush();
						return $this->redirectToRoute('displayBasket');
					}
				}
				return $this->render('PlateformeProductBundle:Basket:update.html.twig',array('form' => $form->createView(),));

	}



	function get_Name($prodid){ 
		$repository = $this->getDoctrine()
				->getManager();
				$repository2=    $repository ->getRepository('PlateformeProductBundle:Products');
				$name = $repository2->findOneByProdid($prodid);
				return $name->getName();
	}  






	/******************************************************Supprimer le basket *****************************************************************/


	public function deletebasketAction($pid)
	{

		$repository = $this->getDoctrine()
				->getManager();
				$repository2=    $repository ->getRepository('PlateformeProductBundle:Basket');

				$basket = $repository2->findOneByPid($pid);

				$repository->remove($basket);
				$repository ->flush();
				// On redirige vers la page de visualisation de l'article
				return $this->redirectToRoute('displayBasket');
	}  

	/******************************************************vider le basket *****************************************************************/


	public function emptybasketAction()
	{

		$user = $this->get('security.token_storage')->getToken()->getUser();
		$userid= $user->getId();

		$repository = $this->getDoctrine()
				->getManager();
				$repository2=    $repository ->getRepository('PlateformeProductBundle:Basket');

				$listBasket = $repository2->findByUserid($userid);

				foreach( $listBasket as $basket){
					$repository->remove($basket);
				}
				$repository ->flush();
				// On redirige vers la page de visualisation de l'article
				return $this->redirectToRoute('displayBasket');
	}




}
