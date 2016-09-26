<?php
namespace Api\ProductBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\View\ViewHandler;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as Rest; 
use Api\ProductBundle\Entity\Orders;
use Api\ProductBundle\Entity\Basket;
use Api\ProductBundle\Form\OrdersType;
use Api\ProductBundle\Entity\Product;
use Api\ProductBundle\Form\ProductType;

use Symfony\Component\HttpFoundation\Response;
class OrderController extends Controller
{

    function get_supplier($prodid){ 

        $repository = $this->getDoctrine()->getManager();
        $repository2=    $repository ->getRepository('ApiProductBundle:Product');
        $supplier = $repository2->findOneById($prodid);
        return $supplier->getFournid();
    }



    /**
     * @Rest\View(statusCode=Response::HTTP_CREATED)
     * @Rest\Post("/orders")
     */
    public function postOrdersAction(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        if ($user != null){
            $userid = $user->getId();
            $order = new Orders();
            $pid = $request->get('pid');
            $order->setProdid($request->get('prodid'))
                     ->setQte($request->get('qte'))
                     ->setUserid($userid)
                     ->setStatus('pending')
                     ->setFournid($this->get_supplier($request->get('prodid')));
            $em = $this->get('doctrine.orm.entity_manager');
            $em->persist($order);
            $em->flush();
            $repository = $this->getDoctrine()
                    ->getManager();
            $repository2 = $repository->getRepository('ApiProductBundle:Basket');
            $basket = $repository2->findOneById($pid);
            $repository->remove($basket);
            $repository->flush();
            return 2;
        }
    }

function get_Name($prodid){ 
        $repository = $this->getDoctrine()->getManager();
        $repository2=  $repository ->getRepository('ApiProductBundle:Product');
        $product = $repository2->findOneById($prodid);
        return $product->getName();
    }

    public function getOrders($orders){
        $formated = [];
        if (empty($orders)) {
            return $formated;
        }           
        foreach($orders as $order){
            $formated[]=[
                'id'=>$order->getId(),
                'qte'=>$order->getQte(),
                'status'=>$order->getStatus(),
                'name'=>$this->get_Name($order->getProdid()),
                'userid'=>$order->getUserid(),
                'fournid'=>$order->getFournid(),
                'prodid'=>$order->getProdid()
            ];
        }
        return $formated;
    }

    /**
     * @Rest\View()
     * @Rest\Get("/orders")
     */
    public function getOrdersAction(Request $request){
        $repository = $this->getDoctrine()->getManager();
        $user = $this->get('security.token_storage')->getToken()->getUser();
        if ($user != null){
            $formated = [];
            $userid = $user->getId();
            $type = $user->getRoles()[0]; 
            if($type == 'client'){
                $query = $repository->createQuery("SELECT o FROM ApiProductBundle:Product p JOIN ApiProductBundle:Orders o WHERE (p.id=o.prodid AND o.userid= $userid )");
                $orders = $query->getResult(); 
                return $this->getOrders($orders);
            } else if ($type == 'vendeur'){
                $repository = $this->getDoctrine()->getManager();
                $query = $repository->createQuery("SELECT o FROM ApiProductBundle:Product p JOIN ApiProductBundle:Orders o WHERE (p.id=o.prodid AND o.fournid= $userid )");
                $orders = $query->getResult();
                return $this->getOrders($orders);
            }
        } else {
            return  [3]; 
        }
    }

    /**
     * @Rest\View()
     * @Rest\Get("/orders/{id}")
     */
    public function getOrderAction(Request $request){
        $order =  $this->getDoctrine()->getManager()
                    ->getRepository('ApiProductBundle:Orders')
                    ->findOneById($request->get('id'));
            if (empty($order)) {
                return new JsonResponse(['message' => 'Order not found'], Response::HTTP_NOT_FOUND);
            }
        $view = View::create($order);
        $view->setFormat('json');
            // Gestion de la réponse
        return $view;
    }



 // public function updateOrder(Request $request, $clearMissing)
 //    {
 //        $order =  $this->getDoctrine()->getManager()
 //                    ->getRepository('ApiProductBundle:Orders')
 //                    ->find($request->get('id'));

 //        if (empty($order)) {
 //            return new JsonResponse(['message' => 'Order not found'], Response::HTTP_NOT_FOUND);
 //        }

 //        $form = $this->createForm(OrdersType::class, $order);

 //        $form->submit($request->request->all(), $clearMissing);

 //            $em = $this->get('doctrine.orm.entity_manager');
 //            // l'entité vient de la base, donc le merge n'est pas nécessaire.
 //            // il est utilisé juste par soucis de clarté
 //            $em->merge($order);
 //            $em->flush();
 //            return $order;

 //    }






     /**
     * @Rest\View()
     * @Rest\Put("/orders/{id}")
     */
    public function updateOrderAction(Request $request)
    {
        $order =  $this->getDoctrine()->getManager()->getRepository('ApiProductBundle:Orders')->find($request->get('id'));

        if (empty($order)) {
            return new JsonResponse(['message' => 'Order not found']);
        }

        $form = $this->createForm(OrdersType::class, $order);

        $form->submit($request->request->all());

            $em = $this->get('doctrine.orm.entity_manager');
            // l'entité vient de la base, donc le merge n'est pas nécessaire.
            // il est utilisé juste par soucis de clarté
            $em->merge($order);
            $em->flush();
            return $order;

    }

    /**
     * @Rest\View()
     * @Rest\Patch("/orders/{id}")
     */
    public function patchOrderAction(Request $request)
    {
        return $this->updatePlace($request, false);
    }


// /**
//      * @Rest\View()
//      * @Rest\Delete("/orders/{id}")
//      */
//     public function removeOrderAction(Request $request)
//     {
//         $em = $this->get('doctrine.orm.entity_manager');
//         $Order = $em->getRepository('ApiOrderBundle:Order')
//                     ->find($request->get('id'));
//         /* @var $Order Order */

//         if ($Order) {
//             $em->remove($Order);
//             $em->flush();
//         }
//         return 2;
//     }


}
