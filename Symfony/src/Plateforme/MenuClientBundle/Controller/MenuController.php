<?php

namespace Plateforme\MenuClientBundle\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Plateforme\ProduitBundle\Entity\Panier;
class MenuController extends Controller
{

	/*public function nbrepanier($userid){

return $i;



}*/


	public function accueilAction()
	{
		$user = $this->get('security.token_storage')->getToken()->getUser();
		$userid= $user->getId();
		$i=0;
		$repository = $this->getDoctrine()
				->getManager();
				$repository2=    $repository ->getRepository('PlateformeProduitBundle:Panier');
				$listepanier = $repository2->findByUserid($userid);

				foreach($listepanier as $panier){
					$i=$i+$panier->getQte();

				};
				$session=new Session();
				$session->set('panier',$i);


				return $this->render('PlateformeMenuClientBundle:Menu:accueil.html.twig',array('panier'=>$i,'user'=>$user));
	}



	public function accueilProfilAction()
	{
		return $this->render('PlateformeMenuClientBundle:Profil:accueil.html.twig');
	}

	public function deconnexionAction(){


		return $this->redirectToRoute('login');

	}


}
