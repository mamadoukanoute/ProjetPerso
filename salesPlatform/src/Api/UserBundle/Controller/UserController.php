<?php
/*use FOS\RestBundle\Controller\Annotations\View;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;*/
namespace Api\UserBundle\Controller;
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
use Api\UserBundle\Entity\User;
use Api\UserBundle\Form\UserType;

use Symfony\Component\HttpFoundation\Response;
class UserController extends Controller
{

    /**
     * @Rest\View(statusCode=Response::HTTP_CREATED)
     * @Rest\Post("/users")
     */
    public function postUsersAction(Request $request)
    {
        $user = new User();
        $user->setUsername($request->get('username'))
             ->setEmail($request->get('email'))
             ->setPassword($request->get('password'))
             ->setSalt("")
             ->setRoles(array($request->get('type')));
        $em = $this->get('doctrine.orm.entity_manager');
        $em->persist($user);
        $em->flush();
        return $user;
    }


    /**
     * @Rest\View()
     * @Rest\Get("/users")
     */
	public function getUsersAction(Request $request){
	if ($request->get('username') && $request->get('password')){
        $username = $request->get('username') ;
        $password = $request->get('password');
        $user =  $this->getDoctrine()->getManager()
                    ->getRepository('ApiUserBundle:User')
                    ->findOneBy(array('username' => $username, 'password' => $password));
        if (empty($user)) {
                return new JsonResponse(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
        }
        //83152728
        $formated[]=[
            'id'=>$user->getId(),
            'username'=>$user->getUsername(),
            'email'=>$user->getEmail(),
        ];
        return $formated;
    } else {
        $users = $this->getDoctrine()->getManager()->getRepository('ApiUserBundle:User')->findAll();
        $formated=[];
        foreach($users as $user){
           	$formated[]=[
           		'id'=>$user->getId(),
           		'username'=>$user->getUsername(),
           		'email'=>$user->getEmail(),
                'type'=>$user->getRoles()[0]
           	];
        }
           return $formated;
    }

  // echo  $jsontab;
   // return new Response("Tous les utilsateurs");
  // return $this->render('ApiUserBundle:Users:show.html.twig',array('jsontab'=>$jsontab));
  }

    /**
     * @Rest\View()
     * @Rest\Get("/users/{id}")
     */
    public function getUserAction(Request $request){
      	$user =  $this->getDoctrine()->getManager()
                    ->getRepository('ApiUserBundle:User')
                    ->find($request->get('id'));
            if (empty($user)) {
                return new JsonResponse(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
            }
        $view = View::create($user);
        $view->setFormat('json');
            // Gestion de la réponse
        return $view;
    }



     /**
     * @Rest\View()
     * @Rest\Put("/users/{id}")
     */
    public function updateUserAction(Request $request)
    {
        $user = $this->get('doctrine.orm.entity_manager')
                ->getRepository('ApiUserBundle:User')
                ->find($request->get('id')); // L'identifiant en tant que paramètre n'est plus nécessaire
        /* @var $user User */

        if (empty($user)) {
            return new JsonResponse(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
        }

        $form = $this->createForm(UserType::class, $user);

        $form->submit($request->request->all());

            $em = $this->get('doctrine.orm.entity_manager');
            // l'entité vient de la base, donc le merge n'est pas nécessaire.
            // il est utilisé juste par soucis de clarté
            $em->merge($user);
            $em->flush();
            return $user;

    }


/**
     * @Rest\View()
     * @Rest\Delete("/users/{id}")
     */
    public function removeUserAction(Request $request)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $user = $em->getRepository('ApiUserBundle:User')
                    ->find($request->get('id'));
        /* @var $user User */

        if ($user) {
            $em->remove($user);
            $em->flush();
        }
        return 2;
    }


}
//}