<?php
/*use FOS\RestBundle\Controller\Annotations\View;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;*/
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
use Api\ProductBundle\Entity\Basket;
use Api\ProductBundle\Form\BasketType;
use Api\ProductBundle\Entity\Product;
use Api\ProductBundle\Form\ProductType;

use Symfony\Component\HttpFoundation\Response;
class BasketController extends Controller
{
    /**
     * @Rest\View(statusCode=Response::HTTP_CREATED)
     * @Rest\Post("/baskets")
     */
    public function postBasketsAction(Request $request)
    {
        $basket = new Basket();
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $userid = $user->getId();
        $basket->setProdid($request->get('prodid'))
                 ->setQte($request->get('qte'))
                 ->setUserid($userid);
        $em = $this->get('doctrine.orm.entity_manager');
        $em->persist($basket);
        $em->flush();

        return $basket;
    }

    function get_Name($prodid){ 
        $repository = $this->getDoctrine()->getManager();
        $repository2=  $repository ->getRepository('ApiProductBundle:Product');
        $product = $repository2->findOneById($prodid);
        return $product->getName();
    }

    /**
     * @Rest\View()
     * @Rest\Get("/baskets")
     */
    public function getBasketsAction(Request $request){
        $user = $this->get('security.token_storage')->getToken()->getUser();
        if($user!=null){
            $userid = $user->getId();
            $repository = $this->getDoctrine()->getManager();
            $query = $repository->createQuery("SELECT b FROM ApiProductBundle:Product p JOIN ApiProductBundle:Basket b WHERE (p.id=b.prodid AND b.userid= $userid )");
             if ($query == null) {
                    return new JsonResponse(['message' => 'You have zero Basket'], Response::HTTP_NOT_FOUND);
            }  
            $list = $query->getResult();        
            $formated=[];
            foreach($list as $Basket){
                $formated[]=[
                    'id'=>$Basket->getId(),
                    'userid'=>$Basket->getUserid(),
                    'qte'=>$Basket->getQte(),
                    'prodid'=>$Basket->getProdid(),
                    'name'=>$this->get_Name($Basket->getProdid())

                ];
            }
        } 
               
        // }
        return $formated;
    }

    /**
     * @Rest\View()
     * @Rest\Get("/baskets/{id}")
     */
    public function getBasketAction(Request $request){
        $Basket =  $this->getDoctrine()->getManager()
                    ->getRepository('ApiBasketBundle:Basket')
                    ->find($request->get('id'));
            if (empty($Basket)) {
                return new JsonResponse(['message' => 'Basket not found'], Response::HTTP_NOT_FOUND);
            }
        $view = View::create($Basket);
        $view->setFormat('json');
            // Gestion de la réponse
        return $view;
    }



     /**
     * @Rest\View()
     * @Rest\Put("/baskets/{id}")
     */
    public function updateBasketAction(Request $request)
    {
        $Basket =  $this->getDoctrine()->getManager()
                    ->getRepository('ApiBasketBundle:Basket')
                    ->find($request->get('id'));

        if (empty($Basket)) {
            return new JsonResponse(['message' => 'Basket not found'], Response::HTTP_NOT_FOUND);
        }

        $form = $this->createForm(BasketType::class, $Basket);

        $form->submit($request->request->all());

            $em = $this->get('doctrine.orm.entity_manager');
            // l'entité vient de la base, donc le merge n'est pas nécessaire.
            // il est utilisé juste par soucis de clarté
            $em->merge($Basket);
            $em->flush();
            return $Basket;

    }


/**
     * @Rest\View()
     * @Rest\Delete("/baskets/{id}")
     */
    public function removeBasketAction(Request $request)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $Basket = $em->getRepository('ApiBasketBundle:Basket')
                    ->find($request->get('id'));
        /* @var $Basket Basket */

        if ($Basket) {
            $em->remove($Basket);
            $em->flush();
        }
        return 2;
    }


}
