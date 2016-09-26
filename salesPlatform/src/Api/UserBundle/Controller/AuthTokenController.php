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
use Api\UserBundle\Entity\AuthToken;
use Api\UserBundle\Entity\Credentials;
use Api\UserBundle\Form\UserType;
use Api\UserBundle\Form\CredentialsType;

use Symfony\Component\HttpFoundation\Response;
class AuthTokenController extends Controller
{
        /**
         * Durée de validité du token en secondes, 12 heures
         */
        const TOKEN_VALIDITY_DURATION = 12 * 3600;

	/**
     * @Rest\View(statusCode=Response::HTTP_CREATED)
     * @Rest\Post("/auth-tokens")
     */
    public function postAuthTokensAction(Request $request)
    {
        $credentials = new Credentials();
        $form = $this->createForm(CredentialsType::class, $credentials);

        $form->submit($request->request->all());
        if (!$form->isValid()) {
            return $form;
        }

        $em = $this->get('doctrine.orm.entity_manager');

        $user = $em->getRepository('ApiUserBundle:User')
            ->findOneByUsername($credentials->getUsername());

        if (!$user) { // L'utilisateur n'existe pas
            return $this->invalidCredentials();
        }

        // $encoder = $this->get('security.password_encoder');
        // $isPasswordValid = $encoder->isPasswordValid($user, $credentials->getPassword());

        // if (!$isPasswordValid) { // Le mot de passe n'est pas correct
        //     return $this->invalidCredentials();
        // }

        $authToken = new AuthToken();
        $authToken->setValue(base64_encode(random_bytes(50)));
        $authToken->setCreatedAt(new \DateTime('now'));
        $authToken->setUser($user);

        $em->persist($authToken);
        $em->flush();

        return $authToken;
        //return $request->request->all();
    }

    private function invalidCredentials()
    {
        return \FOS\RestBundle\View\View::create(['message' => 'Invalid credentials'], Response::HTTP_BAD_REQUEST);
    }

    /**
     * @Rest\View()
     * @Rest\Get("/auth-tokens/{id}")
     */
    public function getAuthTokenAction (Request $request)
    {

        $em = $this->get('doctrine.orm.entity_manager');
        $authToken = $em->getRepository('ApiUserBundle:AuthToken')
                    ->find($request->get('id'));
        /* @var $authToken AuthToken */

        $connectedUser = $this->get('security.token_storage')->getToken()->getUser();

        if ($connectedUser && (time() - $authToken->getCreatedAt()->getTimestamp()) < self::TOKEN_VALIDITY_DURATION) {
            return $connectedUser;
        } else {
            $em->remove($authToken);
            $em->flush();
            throw new \Symfony\Component\HttpKernel\Exception\BadRequestHttpException();
        }
    }    

    /**
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
     * @Rest\Delete("/auth-tokens/{id}")
     */
    public function removeAuthTokenAction(Request $request)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $authToken = $em->getRepository('ApiUserBundle:AuthToken')
                    ->find($request->get('id'));
        /* @var $authToken AuthToken */

        $connectedUser = $this->get('security.token_storage')->getToken()->getUser();

        if ($authToken && $authToken->getUser()->getId() === $connectedUser->getId()) {
            $em->remove($authToken);
            $em->flush();
        } else {
            throw new \Symfony\Component\HttpKernel\Exception\BadRequestHttpException();
        }
    }

}