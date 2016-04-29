<?php

namespace Plateforme\ProduitBundle\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Plateforme\ProduitBundle\Entity\Commandes;
use Plateforme\ProduitBundle\Entity\Panier;
use Plateforme\ProduitBundle\Form\CommandesType;
use Plateforme\ProduitBundle\Form\PanierTest;
use Symfony\Component\HttpFoundation\Response;

class CommandesController extends Controller
{

	public function depotAction(Request $request)
	{


		$user = $this->get('security.token_storage')->getToken()->getUser();
		$userid= $user->getId();
		$repository = $this->getDoctrine()
				->getManager();
				$repository2=    $repository ->getRepository('PlateformeProduitBundle:Panier');
				$listePanier = $repository2->findByUserid($userid);
				foreach($listePanier as $panier){
					echo $panier->getProdid();
					$commande=new Commandes();
					$commande->setProdid($panier->getProdid());
					$commande->setUserid($panier->getUserid());
					$commande->setQte($panier->getQte());
					$commande->setStatut('en cours');
					$commande->setFournid($this->get_fournisseur($panier->getProdid()));
					$repository->persist($commande);
					$repository->flush();


				}
				$this->viderPanierAction($userid);




				return $this->redirectToRoute('afficheCommandes');
				//return new response("problème");
	}




	public function afficherAction(Request $request)
	{
		$repository = $this->getDoctrine()
				->getManager();

				if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED') && $this->get('security.authorization_checker')->isGranted('ROLE_CLIENT')) {
					$user = $this->get('security.token_storage')->getToken()->getUser();
					$userid= $user->getId();
					$query = $repository->createQuery("SELECT a FROM PlateformeProduitBundle:Produits a JOIN PlateformeProduitBundle:Commandes cmd WHERE (a.prodid=cmd.prodid AND cmd.userid='$userid')");
					$liste = $query->getResult();
					$tableau=array();
					$statut=array();
					$tableau_prix=array();
					$tableau_qte=array();
					foreach( $liste as $cmd){
						$tableau[$cmd->getProdid()]=$this->get_nom($cmd->getProdid());
					} 

					foreach( $liste as $cmd){
						$statut[$cmd->getProdid()]=$this->get_statut($cmd->getProdid());
					}

					foreach( $liste as $cmd){
						$tableau_qte[$cmd->getProdid()]=$this->getqtecmd($cmd->getProdid());
					}

					foreach( $liste as $cmd){
						$tableau_prix[$cmd->getProdid()]=$this->getprix($cmd->getProdid())*$tableau_qte[$cmd->getProdid()];
					}



					return $this->render('PlateformeProduitBundle:Commandes:afficher.html.twig',array('liste' => $liste,'tableau'=>$tableau,'statut'=>$statut,'tableau_prix'=>$tableau_prix,'tableau_qte'=>$tableau_qte));
				}
				if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED') && $this->get('security.authorization_checker')->isGranted('ROLE_VENDEUR')) {
					$user = $this->get('security.token_storage')->getToken()->getUser();
					$userid= $user->getId();
					$repository2=    $repository ->getRepository('PlateformeProduitBundle:Commandes');

					$listeCommande = $repository2->findByFournid($userid);
					$tableau=array();
					$tableau_prix=array();
					foreach( $listeCommande as $cmd){
						$tableau[$cmd->getProdid()]=$this->get_nom($cmd->getProdid());
					}

					foreach( $listeCommande as $cmd){
						$tableau_prix[$cmd->getProdid()]=$this->getprix($cmd->getProdid())*$cmd->getQte();
					}

					return $this->render('PlateformeMenuVendeurBundle:Menu:listeCommandes.html.twig',array('liste' => $listeCommande,'tableau'=>$tableau,'tableau_prix'=>$tableau_prix));


				}
	}

	public function accepterAction($prodid)
	{
		$repository = $this->getDoctrine()
				->getManager();
				$repository2=$repository->getRepository('PlateformeProduitBundle:Commandes');

				$listeCommande = $repository2->findOneByProdid($prodid);
				$total=$this->getqte($prodid);
				$sub=$total-$listeCommande->getQte();
				if($sub==0) {
					$repository3=    $repository ->getRepository('PlateformeProduitBundle:Produits');
					$produit = $repository3->findOneByProdid($listeCommande->getProdid());

					$repository->remove($produit);

					$repository4=    $repository ->getRepository('PlateformeProduitBundle:Commandes');
					$commande = $repository4->findOneByProdid($listeCommande->getProdid());
					$repository->remove($commande);

				}
				if($sub==0 ||$sub>0){
					$repository3=    $repository ->getRepository('PlateformeProduitBundle:Commandes');
					$Commande = $repository3->findOneByProdid($prodid);
					$Commande->setStatut("acceptée");
					$repository4=    $repository ->getRepository('PlateformeProduitBundle:Produits');
					$produit = $repository4->findOneByProdid($listeCommande->getProdid());
					$produit->setQte($sub);
					$repository->flush();


				}
				return $this->redirectToRoute('afficheCommandes');
	}
	public function refuserAction($prodid){
		$repository = $this->getDoctrine()
				->getManager();
				$repository3=    $repository ->getRepository('PlateformeProduitBundle:Commandes');
				$Commande = $repository3->findOneByProdid($prodid);
				//}      
				$Commande->setStatut("refusée");
				$repository->flush();
				//return new response("dd");
				return $this->redirectToRoute('afficheCommandes');
				return new response("dd");
	}



	function getprix($prodid){ 
		$repository = $this->getDoctrine()
				->getManager();
				$repository2=    $repository ->getRepository('PlateformeProduitBundle:Produits');

				$fournisseur = $repository2->findOneByProdid($prodid);

				return $fournisseur->getPrix();
	}








	function getqtecmd($prodid){ 
		$repository = $this->getDoctrine()
				->getManager();
				$repository2=    $repository ->getRepository('PlateformeProduitBundle:Commandes');

				$fournisseur = $repository2->findOneByProdid($prodid);

				return $fournisseur->getQte();
	}



	function getqte($prodid){ 
		$repository = $this->getDoctrine()
				->getManager();
				$repository2=    $repository ->getRepository('PlateformeProduitBundle:Produits');

				$fournisseur = $repository2->findOneByProdid($prodid);

				return $fournisseur->getQte();
	}

	function get_nom($prodid){ 
		$repository = $this->getDoctrine()
				->getManager();
				$repository2=    $repository ->getRepository('PlateformeProduitBundle:Produits');
				$nom = $repository2->findOneByProdid($prodid);
				return $nom->getNom();
	}


	function get_statut($prodid){ 
		$repository = $this->getDoctrine()
				->getManager();
				$repository2=    $repository ->getRepository('PlateformeProduitBundle:Commandes');
				$statut = $repository2->findOneByProdid($prodid);
				return $statut->getStatut();
	}

	public function viderPanierAction($userid)
	{


		$repository = $this->getDoctrine()
				->getManager();
				$repository2=    $repository ->getRepository('PlateformeProduitBundle:Panier');

				$listePanier = $repository2->findByUserid($userid);

				foreach( $listePanier as $panier){
					$repository->remove($panier);
				}
				$repository ->flush();
				// On redirige vers la page de visualisation de l'article
				//return $this->redirectToRoute('afficherPanier');
	}




	function get_fournisseur($prodid){ 

		$repository = $this->getDoctrine()
				->getManager();
				$repository2=    $repository ->getRepository('PlateformeProduitBundle:Produits');

				$fournisseur = $repository2->findOneByProdid($prodid);

				return $fournisseur->getFournid();
	}
}
