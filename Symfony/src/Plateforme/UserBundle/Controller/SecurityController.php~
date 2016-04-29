<?php
namespace Plateforme\UserBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

use Plateforme\UserBundle\Entity\User;
use Plateforme\UserBundle\Form\UserbisType;
use Plateforme\ProduitBundle\Entity\Categories;

class SecurityController extends Controller
{


	public function loginAction(Request $request)
	{


		// Si le visiteur est déjà identifié, on le redirige vers
		if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED') && $this->get('security.authorization_checker')->isGranted('ROLE_CLIENT')) {

			return new response("Vous etes un client");
		}
		if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED') && $this->get('security.authorization_checker')->isGranted('ROLE_SERVEUR')) {

			return new response("Vous etes un vendeur");
		}


		else
		{

			$session = $request->getSession();
			// On vérifie s'il y a des erreurs d'une précédente soumission
			if ($request->attributes->has(Security::AUTHENTICATION_ERROR)) {
				$error = $request->attributes->get(Security::AUTHENTICATION_ERROR);
			} else {
				$error = $session->get(Security::AUTHENTICATION_ERROR);
				$session->remove(Security::AUTHENTICATION_ERROR);
			}
			//$this->initialize();
			//return new response("Connexion réussie ");
			return $this->render('PlateformeUserBundle:Security:login.html.twig',array('last_username' => $session->get(Security::LAST_USERNAME),'error'=> $error,));
		}
	}


	/*public function initialize(){

		$repository = $this->getDoctrine()
				->getManager();
				$repository2=    $repository->getRepository('PlateformeProduitBundle:Categories');

				$categories = $repository2->findAll();  
				if($categories==null) {
					$tableau=array(
							'Produits laitiers','Boucherie' ,'Entretien Maison' ,'Hygiène','Boissons','Conserves',
							'Boulangerie','Produits Frais','Chocolat',

							);

					$taille=count($tableau);
					for($i=1;$i<=$taille;$i++){
						$element=new Categories();
						$element->setCatid($i);
						$element->setNom(array_shift($tableau));

						$repository->persist($element);


					}
					$repository->flush();     

				}

	}*/



	public function afficherProfilAction()
	{
		$user = $this->get('security.token_storage')->getToken()->getUser();
		$userid= $user->getId();

		$repository = $this->getDoctrine()
				->getManager()
				->getRepository('PlateformeUserBundle:User');

				$User = $repository->find($userid);   
				return $this->render('PlateformeMenuClientBundle:Profil:afficherProfil.html.twig',array('User' => $User));   


	}

	/***************************************************Modifier le profil*****************************************/

	public function updateProfilAction(Request $request)
	{



		$user = $this->get('security.token_storage')->getToken()->getUser();
		$userid= $user->getId();
		$password= $user->getPassword();
		$repository = $this->getDoctrine()->getManager();;
		$repository2=    $repository ->getRepository('PlateformeUserBundle:User');

		$utilisateur = $repository2->find($userid);


		$utilisateur->password2=$password;

		$form = $this->createForm(UserbisType::class, $utilisateur);
		if ($request->getMethod() == 'POST'){
			$form->handleRequest($request);
			if($form->isValid()) {
				if ($utilisateur->password2==$utilisateur->getPassword()) {
					echo $utilisateur->getPassword();
		;
					$repository ->flush();

					return new response ("La modification a réussi");
				}else 
				{
					echo "mot de passe différent";
					return $this->render('PlateformeMenuClientBundle:Profil:formulaire.html.twig',array('form' => $form->createView(),));

				}
			}
			
		}

		else return $this->render('PlateformeMenuClientBundle:Profil:formulaire.html.twig',array('form' => $form->createView(),));


		return new response ("rien");
	}
}
