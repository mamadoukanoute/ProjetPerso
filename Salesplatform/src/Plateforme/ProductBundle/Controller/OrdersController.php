<?php

namespace Plateforme\ProductBundle\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Plateforme\ProductBundle\Entity\Orders;
use Plateforme\ProductBundle\Entity\basket;
use Plateforme\ProductBundle\Form\OrdersType;
use Plateforme\ProductBundle\Form\basketTest;
use Symfony\Component\HttpFoundation\Response;

class OrdersController extends Controller
{

	public function addOrderAction(Request $request)
	{


		$user = $this->get('security.token_storage')->getToken()->getUser();
		$userid= $user->getId();
		$repository = $this->getDoctrine()
				->getManager();
				$repository2=    $repository ->getRepository('PlateformeProductBundle:Basket');
				$listBasket = $repository2->findByUserid($userid);
				foreach($listBasket as $basket){
					echo $basket->getProdid();
					$Order=new Orders();
					$Order->setProdid($basket->getProdid());
					$Order->setUserid($basket->getUserid());
					$Order->setQte($basket->getQte());
					$Order->setstatus('pending');
					$Order->setFournid($this->get_supplier($basket->getProdid()));
					$repository->persist($Order);
					$repository->flush();


				}
				$this->emptybasket($userid);




				return $this->redirectToRoute('displayOrder');
				//return new response("problème");
	}




	public function displayOrderAction(Request $request)
	{
		$repository = $this->getDoctrine()
				->getManager();

				if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED') && $this->get('security.authorization_checker')->isGranted('ROLE_CLIENT')) {
					$user = $this->get('security.token_storage')->getToken()->getUser();
					$userid= $user->getId();
					$query = $repository->createQuery("SELECT a FROM PlateformeProductBundle:Products a JOIN PlateformeProductBundle:Orders cmd WHERE (a.prodid=cmd.prodid AND cmd.userid='$userid')");
					$list = $query->getResult();
					$tableau=array();
					$status=array();
					$array_price=array();
					$array_amount=array();
					foreach( $list as $cmd){
						$tableau[$cmd->getProdid()]=$this->get_Name($cmd->getProdid());
					} 

					foreach( $list as $cmd){
						$status[$cmd->getProdid()]=$this->get_status($cmd->getProdid());
					}

					foreach( $list as $cmd){
						$array_amount[$cmd->getProdid()]=$this->get_amount_order($cmd->getProdid());
					}

					foreach( $list as $cmd){
						$array_price[$cmd->getProdid()]=$this->getPrice($cmd->getProdid())*$array_amount[$cmd->getProdid()];
					}
					$role="client";


					return $this->render('PlateformeProductBundle:Orders:displayOrder.html.twig',array('list' => $list,'tableau'=>$tableau,'status'=>$status,'array_price'=>$array_price,'array_amount'=>$array_amount,'role'=>$role));
				}
				if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED') && $this->get('security.authorization_checker')->isGranted('ROLE_SELLER')) {
					$user = $this->get('security.token_storage')->getToken()->getUser();
					$userid= $user->getId();
					$repository2=    $repository ->getRepository('PlateformeProductBundle:Orders');

					$list = $repository2->findByFournid($userid);
					$tableau=array();
					$array_price=array();
					foreach( $list as $cmd){
						$tableau[$cmd->getProdid()]=$this->get_Name($cmd->getProdid());
					}

					foreach( $list as $cmd){
						$array_price[$cmd->getProdid()]=$this->getPrice($cmd->getProdid())*$cmd->getQte();
					}
					$role="seller";

					return $this->render('PlateformeProductBundle:Orders:displayOrder.html.twig',array('list' => $list,'tableau'=>$tableau,'array_price'=>$array_price,'role'=>$role));


				}
				return new response("You must be logged");
	}

	public function acceptOrderAction($prodid)
	{
		$repository = $this->getDoctrine()
				->getManager();
				$repository2=$repository->getRepository('PlateformeProductBundle:Orders');

				$listOrder = $repository2->findOneByProdid($prodid);
				$total=$this->getqte($prodid);
				$sub=$total-$listOrder->getQte();
				if($sub==0) {
					$repository3=    $repository ->getRepository('PlateformeProductBundle:Products');
					$Product = $repository3->findOneByProdid($listOrder->getProdid());

					$repository->remove($Product);

					$repository4=    $repository ->getRepository('PlateformeProductBundle:Orders');
					$Order = $repository4->findOneByProdid($listOrder->getProdid());
					$repository->remove($Order);

				}
				if($sub==0 ||$sub>0){
					$repository3=    $repository ->getRepository('PlateformeProductBundle:Orders');
					$Order = $repository3->findOneByProdid($prodid);
					$Order->setstatus("is accepted");
					$repository4=    $repository ->getRepository('PlateformeProductBundle:Products');
					$Product = $repository4->findOneByProdid($listOrder->getProdid());
					$Product->setQte($sub);
					$repository->flush();


				}
				return $this->redirectToRoute('displayOrder');
	}
	public function refuseOrderAction($prodid){
		$repository = $this->getDoctrine()
				->getManager();
				$repository3=    $repository ->getRepository('PlateformeProductBundle:Orders');
				$Order = $repository3->findOneByProdid($prodid);
				//}      
				$Order->setstatus("is refused");
				$repository->flush();
				//return new response("dd");
				return $this->redirectToRoute('displayOrder');

	}
	public function emptybasket($userid)
	{


		$repository = $this->getDoctrine()
				->getManager();
				$repository2=    $repository ->getRepository('PlateformeProductBundle:Basket');

				$listBasket = $repository2->findByUserid($userid);

				foreach( $listBasket as $basket){
					$repository->remove($basket);
				}
				$repository ->flush();
				// On redirige vers la page de visualisation de l'article
				//return $this->redirectToRoute('displayOrderbasket');
	}



	function getPrice($prodid){ 
		$repository = $this->getDoctrine()
				->getManager();
				$repository2=    $repository ->getRepository('PlateformeProductBundle:Products');

				$supplier = $repository2->findOneByProdid($prodid);

				return $supplier->getPrice();
	}








	function get_amount_order($prodid){ 
		$repository = $this->getDoctrine()
				->getManager();
				$repository2=    $repository ->getRepository('PlateformeProductBundle:Orders');

				$supplier = $repository2->findOneByProdid($prodid);

				return $supplier->getQte();
	}



	function getqte($prodid){ 
		$repository = $this->getDoctrine()
				->getManager();
				$repository2=    $repository ->getRepository('PlateformeProductBundle:Products');

				$supplier = $repository2->findOneByProdid($prodid);

				return $supplier->getQte();
	}

	function get_Name($prodid){ 
		$repository = $this->getDoctrine()
				->getManager();
				$repository2=    $repository ->getRepository('PlateformeProductBundle:Products');
				$name= $repository2->findOneByProdid($prodid);
				return $name->getName();
	}


	function get_status($prodid){ 
		$repository = $this->getDoctrine()
				->getManager();
				$repository2=    $repository ->getRepository('PlateformeProductBundle:Orders');
				$status = $repository2->findOneByProdid($prodid);
				return $status->getstatus();
	}

	




	function get_supplier($prodid){ 

		$repository = $this->getDoctrine()
				->getManager();
				$repository2=    $repository ->getRepository('PlateformeProductBundle:Products');

				$supplier = $repository2->findOneByProdid($prodid);

				return $supplier->getFournid();
	}
}
