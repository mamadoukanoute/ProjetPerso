<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Response;

class MenuController extends Controller
{
    
    public function homeAction(Request $request)
    {
        return $this->render('AppBundle:Menu:home.html.twig');
    }

    public function afterloginAction(Request $request)
    {
        return $this->render('AppBundle:Menu:afterlogin.html.twig');
    }

    public function searchformAction()
    {


        return $this->render('AppBundle:Menu:searchform.html.twig');
    }

    public function searchAction()
    {

        $user = $this->get('security.token_storage')->getToken()->getUser();
        $userid= $user->getId();


        $search=$_POST['search'];

        $repository = $this->getDoctrine()
                ->getManager();
                $query = $repository->createQuery("SELECT a FROM AppBundle:Carnet a WHERE  a.idmembre='$userid' AND
                        a.email LIKE '%$search%' ");
                        $carnet = $query->getResult();
                        return $this->render('AppBundle:Carnet:showInfoMembre.html.twig',array('membre'=>$carnet,"url"=>$_SERVER['SCRIPT_NAME']));

    }



}