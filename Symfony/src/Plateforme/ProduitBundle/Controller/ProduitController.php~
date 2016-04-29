<?php
namespace Plateforme\ProduitBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Plateforme\ProduitBundle\Entity\Produits;
use Plateforme\ProduitBundle\Entity\Panier;
use Plateforme\ProduitBundle\Form\ProduitsType;
use Symfony\Component\HttpFoundation\Response;


class ProduitController extends Controller
{

	public $v=0;



	/****************************************Ajout de produit***********************************************************/

	public function depotAction(Request $request)
	{


		$produits = new Produits();
		$user = $this->get('security.token_storage')->getToken()->getUser();
		$userid= $user->getId();
		//$password= $user->getPassword();	

		$produits->setFournid($userid);
		//$produits->setQte(1);
		// On ne se sert pas du sel pour l'instant
		// On crée le FormBuilder grâce à la méthode du contrôleur



		$form = $this->createForm(ProduitsType::class, $produits);
		//$request = $this->get('request');
		//// On vérifie qu'elle est de type POST
		if ($request->getMethod() == 'POST') {
			$form->handleRequest($request);
			if($form->isValid()) {
				if($produits->getQte()==0){
					$produits->setQte(1);
				}
				$nom=$produits->upload($userid);
				$produits->setNomFichier($nom);

				$em = $this->getDoctrine()->getManager();
				$em->persist($produits);
				$em->flush();

				//}

			}
			return new response ("L'insertion a réussi");
		}
		else return $this->render('PlateformeProduitBundle:Produits:depot.html.twig',array('form' => $form->createView(),));
		//return new response("problème");
	}




	/*********************Afficher le produit************************************************************************/

	public function afficherproduitsAction()
	{
		$repository = $this->getDoctrine()
				->getManager();
				$repository2=    $repository ->getRepository('PlateformeProduitBundle:Produits');




				if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED') && $this->get('security.authorization_checker')->isGranted('ROLE_VENDEUR')) {
					$user = $this->get('security.token_storage')->getToken()->getUser();
					$userid= $user->getId();
					$password= $user->getPassword();

					$listeproduits = $repository2->findByFournid($userid);
					$tableau=array();

					foreach( $listeproduits as $produit){
						$tableau[$produit->getCatid()]=$this->get_categorie($produit->getCatid());
					} 
					return $this->render('PlateformeMenuVendeurBundle:Menu:afficher.html.twig',array('listeproduits'=>$listeproduits,'tableau'=>$tableau));

				}else if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED') && $this->get('security.authorization_checker')->isGranted('ROLE_CLIENT')) {
					$listeproduits = $repository2->findAll();

					$tableau=array();


					foreach( $listeproduits as $produit){
						$tableau[$produit->getCatid()]=$this->get_categorie($produit->getCatid());
					} 
					return $this->render('PlateformeMenuClientBundle:Menu:afficher.html.twig',array('listeproduits'=>$listeproduits,'tableau'=>$tableau));

				}
	}


	/**************************************************Ajouter des elements dans le panier*******************************/
	public function ajoutPanierAction($prodid)
	{

		$repository = $this->getDoctrine()
				->getManager();
				$repositorybis=    $repository ->getRepository('PlateformeProduitBundle:Panier');
				$panier = $repositorybis->findOneByProdid($prodid);
				if($panier!=null) 		return $this->redirectToRoute('afficherProduit');
				$repository2=    $repository ->getRepository('PlateformeProduitBundle:Produits');

				$listeproduits = $repository2->findOneByProdid($prodid);


				$panier = new Panier();
				$user = $this->get('security.token_storage')->getToken()->getUser();
				$userid= $user->getId();
				//$password= $user->getPassword();	

				$panier->setUserid($userid);
				$panier->setProdid($prodid);
				$panier->setQte(1);
				// On ne se sert pas du sel pour l'instant
				// On crée le FormBuilder grâce à la méthode du contrôleur

				$em = $this->getDoctrine()->getManager();
				$em->persist($panier);
				$em->flush();

				//}
				return $this->render('PlateformeMenuClientBundle:Menu:Apresajout.html.twig',array('listeproduits'=>$listeproduits));
				//return new response("problème");
	}






	/******************************************Modifier le produit****************************************************/

	public function updateproduitsAction($prodid,Request $request)
	{

		$repository = $this->getDoctrine()
				->getManager();
				$repository2=    $repository ->getRepository('PlateformeProduitBundle:Produits');
				$listeproduits = $repository2->findOneByProdid($prodid);

				$produit=$listeproduits;
				$form = $this->createForm( ProduitsType::class, $produit);
				//$request = $this->get('request'); 
				if ($request->getMethod() == 'POST'){
					$form->handleRequest($request);
					if($form->isValid()) {
						// On l'enregistre notre objet $article dans la base de
						/*$em = $this->getDoctrine()->getManager();
$em->refresh($panier);*/

						$repository ->flush();
						// On redirige vers la page de visualisation de l'article
						return new response ("La modification a réussi");
					}
				}







				else return $this->render('PlateformeProduitBundle:Produits:depot.html.twig',array('form' => $form->createView(),));


	}

	/******************************************************Supprimer le produits *****************************************************************/


	public function deleteproduitAction($prodid)
	{

		$repository = $this->getDoctrine()
				->getManager();
				$repository2=    $repository ->getRepository('PlateformeProduitBundle:Produits');

				$produit = $repository2->findOneByProdid($prodid);

				$repository->remove($produit);

				$repository3=    $repository ->getRepository('PlateformeProduitBundle:Panier');

				$panier = $repository3->findOneByProdid($prodid);
				if($panier!=null)
					$repository->remove($panier);
					$repository4=    $repository ->getRepository('PlateformeProduitBundle:Commandes');

					$commande = $repository4->findOneByProdid($prodid);

					$repository->remove($commande);

					$repository ->flush();
					// On redirige vers la page de visualisation de l'article
					return $this->redirectToRoute('afficherProduit');
	}

	public function viderProduitAction()
	{

		$user = $this->get('security.token_storage')->getToken()->getUser();
		$userid= $user->getId();

		$repository = $this->getDoctrine()
				->getManager();
				$repository2=    $repository ->getRepository('PlateformeProduitBundle:Produits');

				$listePanier = $repository2->findByFournid($userid);

				foreach( $listePanier as $panier){
					$repository->remove($panier);
				}
				$repository ->flush();
				// On redirige vers la page de visualisation de l'article
				return $this->redirectToRoute('afficherProduit');
	}


	function get_categorie($catid){ 
		$repository = $this->getDoctrine()
				->getManager();
				$repository2=    $repository ->getRepository('PlateformeProduitBundle:Categories');
				$nom = $repository2->findOneByCatid($catid);
				return $nom->getNom();
	}




}

