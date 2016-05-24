<?php


namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Carnet;
use AppBundle\Form\CarnetType;
use AppBundle\Entity\Importer;
use AppBundle\Form\ImporterType;
use Symfony\Component\HttpFoundation\Response;

class CarnetController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */

    public function showAction(Request $request)
    {

        $repository = $this->getDoctrine()
                ->getManager();
                $repository2=    $repository ->getRepository('AppBundle:Carnet');


                $user = $this->get('security.token_storage')->getToken()->getUser();
                $userid= $user->getId();
                $listCarnet = $repository2->findByIdmembre($userid);


                return $this->render('AppBundle:Carnet:show.html.twig',array('listCarnet' => $listCarnet,));
    }


    public function showInfoMembreAction(Request $request,$id)
    {

        $repository = $this->getDoctrine()
                ->getManager();
                $repository2=    $repository ->getRepository('AppBundle:Carnet');

                $membre = $repository2->findById($id);


                return $this->render('AppBundle:Carnet:showInfoMembre.html.twig',array('membre' => $membre,"url"=>$_SERVER['SCRIPT_NAME']));
    }



    public function addAction(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $userid= $user->getId();
        $Carnet = new Carnet();  
        $Carnet->setIdmembre($userid);
        $form = $this->createForm(CarnetType::class, $Carnet);
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($Carnet);
                $em->flush();
            }
            return $this->redirectToRoute('showCarnet');
        }
        else return $this->render('AppBundle:Carnet:add.html.twig',array('form' => $form->createView(),));
        //return new response("problème");
    }



    public function updateAction($id,Request $request)
    {

        $repository = $this->getDoctrine()
                ->getManager();
                $repository2=    $repository ->getRepository('AppBundle:Carnet');
                $listCarnet = $repository2->findOneById($id);
                $listCarnet=$listCarnet;
                $form = $this->createForm( CarnetType::class, $listCarnet);
                if ($request->getMethod() == 'POST'){
                    $form->handleRequest($request);
                    if($form->isValid()) {
                        $repository ->flush();
                        return new response ("The update was successful");
                    }
                }

                return $this->render('AppBundle:Carnet:add.html.twig',array('form' => $form->createView(),));

    }

    public function deleteAction($id)
    {

        $repository = $this->getDoctrine()
                ->getManager();
                $repository2=    $repository ->getRepository('AppBundle:Carnet');

                $Carnet= $repository2->findOneById($id);

                $repository->remove($Carnet);

                $repository ->flush();
                // On redirige vers la page de visualisation de l'article
                return $this->redirectToRoute('showCarnet');
    }


    public function exporterAction(Request $request)
    {

        $repository = $this->getDoctrine()
                ->getManager();
                $repository2=    $repository ->getRepository('AppBundle:Carnet');


                $user = $this->get('security.token_storage')->getToken()->getUser();
                $userid= $user->getId();
                $listCarnet = $repository2->findByIdmembre($userid);

                $nomfichier=$userid."."."txt";

                $this->ecrire($nomfichier,$listCarnet);

                return $this->render('AppBundle:Menu:apresexportation.html.twig',array("userid"=>$userid));


    }


    public function importerAction(Request $request)
    {

        $user = $this->get('security.token_storage')->getToken()->getUser();
        $userid= $user->getId();

        $Importer = new Importer();  
        $form = $this->createForm(ImporterType::class, $Importer);
        $em = $this->getDoctrine()->getManager();
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if($form->isValid()) {
                $nomfichier=$Importer->upload($userid);
                chdir($this->getUploadRootDir());
                $this->lire($nomfichier,$em,$userid);

                return $this->redirectToRoute('showCarnet');
                // echo $pieces[3] . "4 <br/>";
            }



        }    

        else return $this->render('AppBundle:Carnet:importer.html.twig',array('form' => $form->createView(),));


    }

    public function lire($nomfichier,$em,$userid){

        $f = file($nomfichier);
        foreach ($f as $lineNumber => $lineContent)
        {
            $Carnet=new Carnet();
            $Carnet->setIdmembre($userid);

            // $content=fgets($f,400);
            $pieces = explode("$",$lineContent);
            $tab=$pieces;
            $Carnet->setEmail($tab[0]);
            $Carnet->setAdresse($tab[1]);

            $Carnet->setTelephone($tab[2]);

            $Carnet->setSiteweb($tab[3]);

            $em->persist($Carnet);
            $em->flush();
        }

        unlink($nomfichier);

    }

    public function ecrire($nomfichier,$listCarnet){

        chdir($this->getUploadRootDir());
        $file = fopen($nomfichier, 'w+');
        $i=0;
        foreach( $listCarnet as $carnet){

            fputs($file, $carnet->getEmail());
            fputs($file,"$");
            fputs($file, $carnet->getAdresse());
            fputs($file, "$");
            fputs($file, $carnet->getTelephone());
            fputs($file, "$");
            fputs($file, $carnet->getSiteweb());
            if($i>0){
                fputs($file, "\n");
                $i++;
            }else $i++;

        }



    }


    public function getUploadDir()
    {
        return 'uploads/Carnets';

    }

    protected function getUploadRootDir()
    {
        // On retourne le chemin relatif vers l'image pour notre code PHP
        return __DIR__.'/../../../web/'.$this->getUploadDir();
    }



}

