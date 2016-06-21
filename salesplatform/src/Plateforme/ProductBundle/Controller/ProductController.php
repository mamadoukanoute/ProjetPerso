<?php
namespace Plateforme\ProductBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Plateforme\ProductBundle\Entity\Products;
use Plateforme\ProductBundle\Entity\basket;
use Plateforme\ProductBundle\Form\ProductsType;
use Symfony\Component\HttpFoundation\Response;


class ProductController extends Controller
{

	public $v=0;



	/****************************************Ajout de Product***********************************************************/

	public function addProductAction(Request $request)
	{


		$Products = new Products();
		$user = $this->get('security.token_storage')->getToken()->getUser();
		$userid= $user->getId();
		//$password= $user->getPassword();	

		$Products->setFournid($userid);
		//$Products->setQte(1);
		// On ne se sert pas du sel pour l'instant
		// On crée le FormBuilder grâce à la méthode du contrôleur



		$form = $this->createForm(ProductsType::class, $Products);
		//$request = $this->get('request');
		//// On vérifie qu'elle est de type POST
		if ($request->getMethod() == 'POST') {
			$form->handleRequest($request);
			if($form->isValid()) {
				$name_file=$Products->upload($userid);
				$Products->setNameFichier($name_file);

				$em = $this->getDoctrine()->getManager();
				$em->persist($Products);
				$em->flush();

				//}

			}
				return $this->redirectToRoute('displayProduct');
		}
		else return $this->render('PlateformeProductBundle:Products:add.html.twig',array('form' => $form->createView(),));
		//return new response("problème");
	}




	/*********************Afficher le Product************************************************************************/

	public function displayproductsAction()
	{
		$repository = $this->getDoctrine()
				->getManager();
				$repository2=    $repository ->getRepository('PlateformeProductBundle:Products');




				if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED') && $this->get('security.authorization_checker')->isGranted('ROLE_SELLER')) {
					$user = $this->get('security.token_storage')->getToken()->getUser();
					$userid= $user->getId();
					$password= $user->getPassword();

					$listProducts = $repository2->findByFournid($userid);
					$tableau=array();
					$role="seller";
					foreach( $listProducts as $Product){
						$tableau[$Product->getTypeid()]=$this->get_type($Product->getTypeid());
					} 
					return $this->render('PlateformeProductBundle:Products:show.html.twig',array('listProducts'=>$listProducts,'tableau'=>$tableau,'role'=>$role));

				}else if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED') && $this->get('security.authorization_checker')->isGranted('ROLE_CLIENT')) {
					$listProducts = $repository2->findAll();

					$tableau=array();
					$role="client";

					foreach( $listProducts as $Product){
						$tableau[$Product->getTypeid()]=$this->get_type($Product->getTypeid());
					} 
					return $this->render('PlateformeProductBundle:Products:show.html.twig',array('listProducts'=>$listProducts,'tableau'=>$tableau,'role'=>$role));

				}
				return new response("Inscrivez-vous");
	}


	/**************************************************Ajouter des elements dans le basket*******************************/
	public function addBasketAction($prodid)
	{

		$repository = $this->getDoctrine()
				->getManager();
				$repositorybis=    $repository ->getRepository('PlateformeProductBundle:Basket');
				$basket = $repositorybis->findOneByProdid($prodid);
				if($basket!=null) 		return $this->redirectToRoute('displayProduct');
				$repository2=    $repository ->getRepository('PlateformeProductBundle:Products');

				$listProducts = $repository2->findOneByProdid($prodid);


				$basket = new basket();
				$user = $this->get('security.token_storage')->getToken()->getUser();
				$userid= $user->getId();
				//$password= $user->getPassword();	

				$basket->setUserid($userid);
				$basket->setProdid($prodid);
				$basket->setQte(1);
				// On ne se sert pas du sel pour l'instant
				// On crée le FormBuilder grâce à la méthode du contrôleur

				$em = $this->getDoctrine()->getManager();
				$em->persist($basket);
				$em->flush();

				//}
				return $this->render('PlateformeMenuClientBundle:Menu:after_adding_basket.html.twig',array('listProducts'=>$listProducts));
				//return new response("problème");
	}






	/******************************************Modifier le Product****************************************************/

	public function updateProductsAction($prodid,Request $request)
	{

		$repository = $this->getDoctrine()
				->getManager();
				$repository2=    $repository ->getRepository('PlateformeProductBundle:Products');
				$listProducts = $repository2->findOneByProdid($prodid);

				$Product=$listProducts;
				$form = $this->createForm( ProductsType::class, $Product);
				//$request = $this->get('request'); 
				if ($request->getMethod() == 'POST'){
					$form->handleRequest($request);
					if($form->isValid()) {
						// On l'enregistre notre objet $article dans la base de
						/*$em = $this->getDoctrine()->getManager();
$em->refresh($basket);*/

						$repository ->flush();
						// On redirige vers la page de visualisation de l'article
				return $this->redirectToRoute('displayProduct');
					}
				}







				else return $this->render('PlateformeProductBundle:Products:add.html.twig',array('form' => $form->createView(),));


	}

	/******************************************************Supprimer le Products *****************************************************************/


	public function deleteProductAction($prodid)
	{

		$repository = $this->getDoctrine()
				->getManager();
				$repository2=    $repository ->getRepository('PlateformeProductBundle:Products');

				$Product = $repository2->findOneByProdid($prodid);

				$repository->remove($Product);

				$repository3=    $repository ->getRepository('PlateformeProductBundle:Basket');

				$basket = $repository3->findOneByProdid($prodid);
				if($basket!=null)
					$repository->remove($basket);
					$repository4=    $repository ->getRepository('PlateformeProductBundle:Orders');
					$commande = $repository4->findOneByProdid($prodid);
					if($commande!=null)
					$repository->remove($commande);

					$repository ->flush();
					// On redirige vers la page de visualisation de l'article
					return $this->redirectToRoute('displayProduct');
	}

	public function emptyProductAction()
	{

		$user = $this->get('security.token_storage')->getToken()->getUser();
		$userid= $user->getId();

		$repository = $this->getDoctrine()
				->getManager();
				$repository2=    $repository ->getRepository('PlateformeProductBundle:Products');

				$listbasket = $repository2->findByFournid($userid);

				foreach( $listbasket as $basket){
					$repository->remove($basket);
				}
				$repository ->flush();
				// On redirige vers la page de visualisation de l'article
				return $this->redirectToRoute('displayProduct');
	}


	function get_type($Typeid){ 
		$repository = $this->getDoctrine()
				->getManager();
				$repository2=    $repository ->getRepository('PlateformeProductBundle:Type');
				$name = $repository2->findOneByTypeid($Typeid);
				return $name->getName();
	}




}




