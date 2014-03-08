<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Map2u\WebgisBundle\Listener;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;

/**
 * Refere to http://stackoverflow.com/questions/8607212/symfony2-ajax-login
 * @author yoni
 *
 */
class AjaxAuthenticationListener implements AuthenticationSuccessHandlerInterface, AuthenticationFailureHandlerInterface {

    protected $csrf_provider;
    protected $router;

    /**
     * In case we have Failure I need to provide a new csrf token
     * @param unknown_type $csrf_provider
     * @author Yoni Alhadeff
     */
    public function __construct($csrf_provider, $router) {
        $this->csrf_provider = $csrf_provider;
        $this->router = $router;
    }

    /**
     * This is called when an interactive authentication attempt succeeds. This
     * is called by authentication listeners inheriting from
     * AbstractAuthenticationListener.
     *
     * @see SymfonyComponentSecurityHttpFirewallAbstractAuthenticationListener
     * @param Request        $request
     * @param TokenInterface $token
     * @return Response the response to return
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token) {
        if (true === $request->isXmlHttpRequest()) {
            
 //           return new Response("success");
        }

        //default redirect operation.
        return parent::onAuthenticationSuccess($request, $token);
    }

    /**
     * This is called when an interactive authentication attempt fails. This is
     * called by authentication listeners inheriting from
     * AbstractAuthenticationListener.
     *
     * @param Request                 $request
     * @param AuthenticationException $exception
     * @return Response the response to return
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception) {
        if (true === $request->isXmlHttpRequest()) {
            return new Response("failure");
        }

        //default redirect operation.
        return parent::onAuthenticationFailure($request, $exception);

        //   if ($request->isXmlHttpRequest())
        //    {
        //    $result = array('success' => false, 'error'=>$exception->getMessage(),'token'=>$this->csrf_provider->generateCsrfToken('authenticate'));
        //    $response = new Response(json_encode($result));
        //    $response->headers->set('Content-Type', 'application/json');
        //    return $response;
        //  } else
        //   {
        // Create a flash message with the authentication error message
        //    $request->getSession()->setFlash('error', $exception->getMessage());
        //     $url = $this->router->generate('fos_frontend_security_login');
        //   return new RedirectResponse($url);
        //  }
    }

}

?>
