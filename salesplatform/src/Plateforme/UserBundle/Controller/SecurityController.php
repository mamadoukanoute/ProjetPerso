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
use Plateforme\ProductBundle\Entity\Type;

class SecurityController extends Controller
{


	public function loginAction(Request $request)
	{


		// Si le visiteur est déjà identifié, on le redirige vers
		$session = $request->getSession();
			// On vérifie s'il y a des erreurs d'une précédente soumission
			if ($request->attributes->has(Security::AUTHENTICATION_ERROR)) {
				$error = $request->attributes->get(Security::AUTHENTICATION_ERROR);
			} else {
				$error = $session->get(Security::AUTHENTICATION_ERROR);
				$session->remove(Security::AUTHENTICATION_ERROR);
			}
			$this->initialize();
			//return new response("Connexion réussie ");
			return $this->render('PlateformeUserBundle:Security:login.html.twig',array('last_username' => $session->get(Security::LAST_USERNAME),'error'=> $error,));
		}


	public function initialize(){

		$repository = $this->getDoctrine()
				->getManager();
				$repository2=    $repository->getRepository('PlateformeProductBundle:Type');

				$categories = $repository2->findAll();  
				if($categories==null) {
					$tableau=array(
							'Produits laitiers','Boucherie' ,'Entretien Maison' ,'Hygiène','Boissons','Conserves',
							'Boulangerie','Produits Frais','Chocolat',

							);

					$taille=count($tableau);
					for($i=1;$i<=$taille;$i++){
						$element=new Type();
						$element->setTypeid($i);
						$element->setName(array_shift($tableau));

						$repository->persist($element);


					}
					$repository->flush();     

				}

	}



	public function showProfileAction()
	{
		$user = $this->get('security.token_storage')->getToken()->getUser();
		$userid= $user->getId();

		$repository = $this->getDoctrine()
				->getManager()
				->getRepository('PlateformeUserBundle:User');

				$User = $repository->find($userid);   
					if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED') && $this->get('security.authorization_checker')->isGranted('ROLE_CLIENT')) {
						$role="client";
					}
					if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED') && $this->get('security.authorization_checker')->isGranted('ROLE_SELLER')) {
						$role="seller";
					}
				return $this->render('PlateformeUserBundle:Security:showProfil.html.twig',array('User' => $User,'role'=>$role));   


	}

	/***************************************************Modifier le profil*****************************************/

	public function updateProfilAction(Request $request)
	{



		$user = $this->get('security.token_storage')->getToken()->getUser();
		$userid= $user->getId();
		$password= $user->getPassword();
		$repository = $this->getDoctrine()->getManager();;
		$repository2=    $repository ->getRepository('PlateformeUserBundle:User');

		$user = $repository2->find($userid);


		$user->password2=$password;

			if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED') && $this->get('security.authorization_checker')->isGranted('ROLE_CLIENT')) {
						$role="client";
					}
					if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED') && $this->get('security.authorization_checker')->isGranted('ROLE_SELLER')) {
						$role="seller";
					}

		$form = $this->createForm(UserbisType::class, $user);
		if ($request->getMethod() == 'POST'){
			$form->handleRequest($request);
			if($form->isValid()) {
				if ($user->password2==$user->getPassword()) {
					echo $user->getPassword();
		;
					$repository ->flush();

					return new response ("The update was successfull");
				}else 
				{
					echo "mot de passe différent";
					return $this->render('PlateformeUserBundle:Security:formulaire.html.twig',array('form' => $form->createView(),'role'=>$role));

				}
			}
			
		}

		else return $this->render('PlateformeUserBundle:Security:formulaire.html.twig',array('form' => $form->createView(),'role'=>$role));


		return new response ("rien");
	}


		public function log_outAction(){


		return $this->redirectToRoute('login');

	}
}
