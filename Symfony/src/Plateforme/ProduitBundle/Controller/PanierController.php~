<?php

namespace Plateforme\ProduitBundle\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Plateforme\ProduitBundle\Entity\Panier;
use Plateforme\ProduitBundle\Form\PanierType;
use Plateforme\ProduitBundle\Form\PanierTest;
use Symfony\Component\HttpFoundation\Response;

class PanierController extends Controller
{

	public $v=0;



	public function AccueilAction()
	{
		return $this->render('PlateformeVieetudianteBundle:Annonces:accueil.html.twig');
	}




	/*********************Afficher,Modifier,Supprimer le panier************************************************************************/

	public function afficherPanierAction(Request $request)
	{

		$user = $this->get('security.token_storage')->getToken()->getUser();
		$userid= $user->getId();
		$repository = $this->getDoctrine()
				->getManager();
				$repository2=    $repository ->getRepository('PlateformeProduitBundle:Panier');
				// $listeProduits=    $repository ->getRepository('PlateformeProduitBundle:Produits');
				$listePanier = $repository2->findByUserid($userid);
				$tableau=array();
				foreach( $listePanier as $cmd){
					$tableau[$cmd->getProdid()]=$this->get_nom($cmd->getProdid());
				} 

				//$listePanier = $repository2->findByUserid($userid);
				return $this->render('PlateformeProduitBundle:Panier:afficher.html.twig',array('listePanier'=>$listePanier,'tableau'=>$tableau));

	}

	//else return $this->render('PlateformeProduitBundle:Panier:afficher.html.twig',array('listePanier'=>$listePanier,'listeProduits'=>$listeProduits,'arrayListe' =>$responseArray ));



	/******************************************Modifier le panier****************************************************/

	public function updatePanierAction($pid,Request $request)
	{

		$repository = $this->getDoctrine()
				->getManager();
				$repository2=    $repository ->getRepository('PlateformeProduitBundle:Panier');
				$listepanier = $repository2->findOneByPid($pid);
				$panier=$listepanier;
				$session=new Session();
				$quantiteold=$panier->getQte();
				$quantitenew;
				$resultatqte;
				$quantitesession=intval($session->get('panier'));
				//echo $quantitesession;
				$qtefinale;
				//$panier=$listepanier;
				$form = $this->createForm( PanierType::class, $panier);
				if ($request->getMethod() == 'POST'){
					$form->handleRequest($request);
					if($form->isValid()) {
						$quantitenew=$panier->getQte();
						$resultatqte=$quantitenew-$quantiteold;
						$qtefinale=$quantitesession+$resultatqte;
						$session->set('panier',$qtefinale);
						// On l'enregistre notre objet $article dans la base de
						/*$em = $this->getDoctrine()->getManager();*/
						//s$repository->refresh($panier);
						$repository ->flush();
						return $this->redirectToRoute('afficherPanier');
					}
				}
				return $this->render('PlateformeProduitBundle:Panier:depot.html.twig',array('form' => $form->createView(),));

	}



	function get_nom($prodid){ 
		$repository = $this->getDoctrine()
				->getManager();
				$repository2=    $repository ->getRepository('PlateformeProduitBundle:Produits');
				$nom = $repository2->findOneByProdid($prodid);
				return $nom->getNom();
	}  






	/******************************************************Supprimer le panier *****************************************************************/


	public function deletePanierAction($pid)
	{

		$repository = $this->getDoctrine()
				->getManager();
				$repository2=    $repository ->getRepository('PlateformeProduitBundle:Panier');

				$panier = $repository2->findOneByPid($pid);

				$repository->remove($panier);
				$repository ->flush();
				// On redirige vers la page de visualisation de l'article
				return $this->redirectToRoute('afficherPanier');
	}  

	/******************************************************vider le panier *****************************************************************/


	public function viderPanierAction()
	{

		$user = $this->get('security.token_storage')->getToken()->getUser();
		$userid= $user->getId();

		$repository = $this->getDoctrine()
				->getManager();
				$repository2=    $repository ->getRepository('PlateformeProduitBundle:Panier');

				$listePanier = $repository2->findByUserid($userid);

				foreach( $listePanier as $panier){
					$repository->remove($panier);
				}
				$repository ->flush();
				// On redirige vers la page de visualisation de l'article
				return $this->redirectToRoute('afficherPanier');
	}




}
