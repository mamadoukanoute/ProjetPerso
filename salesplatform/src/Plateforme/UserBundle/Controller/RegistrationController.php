<?php

namespace Plateforme\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

use Plateforme\UserBundle\Entity\User;
use Plateforme\UserBundle\Form\UserType;



class RegistrationController extends Controller
{
    public function registerAction(Request $request)
{

        $user = new User();
	$user->setSalt("");
        // On ne se sert pas du sel pour l'instant
      //$user->setSalt('');
      // On définit uniquement le role ROLE_USER qui est le role de base
      //$user->setRoles(array('ROLE_USER_ANNONCES'));
// On crée le FormBuilder grâce à la méthode du contrôleur

$form = $this->createForm(UserType::class, $user);
//$request = $this->get('request');
//// On vérifie qu'elle est de type POST
if ($request->getMethod() == 'POST') {
 $form->handleRequest($request);
 if($form->isValid()) {
// On l'enregistre notre objet $article dans la base de
$em = $this->getDoctrine()->getManager();
$user->setRoles(array($user->type));
$em->persist($user);
$em->flush();
// On redirige vers la page de visualisation de l'article
return $this->render('PlateformeUserBundle:Register:after.html.twig');
//}

}
}
else return $this->render('PlateformeUserBundle:Register:formulaire.html.twig',array('form' => $form->createView(),));

}
}
