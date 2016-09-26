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
use Symfony\Component\Security\Core\Security;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as Rest; 
use Api\ProductBundle\Entity\Product;
use Api\ProductBundle\Form\ProductType;

use Symfony\Component\HttpFoundation\Response;
class ProductController extends Controller
{

    public function getUploadDir()
    {
        return 'uploads/Products_img';
    }

    public function getUploadRootDir()
    {
        // On retourne le chemin relatif vers l'image pour notre code PHP
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    public function save_to_file($image, $userid, $type){
        //chdir($this->getUploadRootDir());
        if(file_exists("uploads")){
            chdir("uploads");
        }else{
            mkdir("uploads", 0777);
            chdir("uploads");
        }
        $date_Depot= new \DateTime("now");
        $name = $userid."_".$date_Depot->format('d-m-Y H:i:s').".".$type;
        $fp = fopen($name, 'w');
        fwrite($fp, $image);
        fclose($fp);
        return $name;
    }
    public function encodage($data, $type){
        $first = $data;
        $before_type = explode("/", $first)[0].'/'.$type.';base64,';
        return $before_type;
    }
    public function traitement_image($data_url, $userid){
        $tmp = $data_url;
        $first = explode(";", $tmp)[0];
        $second = explode(";", $tmp)[1];
        $type = explode("/", $first)[1];
        $encodage = $this->encodage($first, $type);
        $image = base64_decode(str_replace($encodage, '', $data_url));
        return $this->save_to_file($image, $userid, $type);
    }




    /**
     * @Rest\View(statusCode=Response::HTTP_CREATED)
     * @Rest\Post("/products")
     */
    public function postProductsAction(Request $request)
    {
        $product = new Product();
        $file = $request->get('name_file');
        $fournid = $request->get('fournid');
        $name_file = $this->traitement_image($file, $fournid);
        $product->setName($request->get('name'))
                 ->setDescription($request->get('description'))
                 ->setQte($request->get('qte'))
                 ->setPrice($request->get('price'))
                 ->setTypeid($request->get('typeid'))
                 ->setFournid($request->get('fournid'))
                 ->setNameFile($name_file);
        $em = $this->get('doctrine.orm.entity_manager');
        $em->persist($product);
        $em->flush();

        return $product;
    }


    public function getProducts($products){
        $formated=[];
        if (empty($products)) {
            return $formated;
        }           
        foreach($products as $product){
            $formated[]=[
                'id'=>$product->getId(),
                'name'=>$product->getName(),
                'description'=>$product->getDescription(),
                'qte'=>$product->getQte(),
                'price'=>$product->getPrice(),
                'typeid'=>$product->getTypeid(),
                'fournid'=>$product->getFournid(),
                'name_file'=>$product->getNameFile(),
                'rating'=>$product->getRating()
            ];
        }
        return $formated;
    }

    /**
     * @Rest\View()
     * @Rest\Get("/products")
     */
    public function getProductsAction(Request $request){
        $repository = $this->getDoctrine()->getManager();
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $type = $user->getRoles()[0];
        if ($user != null ){
            if($type == 'vendeur'){
                $userid = $user->getId();
                if($request->get('search')){
                    $search = $request->get('search');
                    $query = $repository->createQuery("SELECT a FROM ApiProductBundle:Product a WHERE a.name LIKE '%$search%' AND a.fournid = '$userid'");
                    $Products = $query->getResult();
                    return $this->getProducts($Products);
                } else {
                    $Products = $repository->getRepository('ApiProductBundle:Product')->findByFournid($userid);
                    return $this->getProducts($Products);
                }
            } else if ($type == 'client'){
                if($request->get('search')){
                    $search = $request->get('search');
                    $query = $repository->createQuery("SELECT a FROM ApiProductBundle:Product a WHERE a.name LIKE '%$search%'");
                    $Products = $query->getResult();
                    return $this->getProducts($Products);
                } else {
                    $Products = $repository->getRepository('ApiProductBundle:Product')->findAll();
                    return $this->getProducts($Products);  
                }    
            }else {
                $Products = $repository->getRepository('ApiProductBundle:Product')->findAll();
                return $this->getProducts($Products);
            }
        }
    }
    /**
     * @Rest\View()
     * @Rest\Get("/products/{id}")
     */
    public function getProductAction(Request $request){
        $Product =  $this->getDoctrine()->getManager()
                    ->getRepository('ApiProductBundle:Product')
                    ->find($request->get('id'));
        if (empty($Product)) {
            throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException('product not found');
        }
        $view = View::create($Product);
        $view->setFormat('json');
            // Gestion de la réponse
        return $view;
    }



     public function updateProduct(Request $request, $clearMissing)
        {

        $Product =  $this->getDoctrine()->getManager()
                    ->getRepository('ApiProductBundle:Product')
                    ->find($request->get('id'));

        if (empty($Product)) {
            throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException('product not found');
        }

        $form = $this->createForm(ProductType::class, $Product);

        $form->submit($request->request->all(), $clearMissing);

            $em = $this->get('doctrine.orm.entity_manager');
            // l'entité vient de la base, donc le merge n'est pas nécessaire.
            // il est utilisé juste par soucis de clarté
            $em->merge($Product);
            $em->flush();
            return $Product;

        }


     /**
     * @Rest\View()
     * @Rest\Put("/products/{id}")
     */
    public function updateProductAction(Request $request)
    {
        $this->updateProduct($request, false);
    }


    /**
     * @Rest\View()
     * @Rest\Delete("/products/{id}")
     */
    public function removeProductAction(Request $request)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $Product = $em->getRepository('ApiProductBundle:Product')
                    ->find($request->get('id'));
        /* @var $Product Product */

        if ($Product) {
            $em->remove($Product);
            $em->flush();
        }
        return 2;
    }


}
//}