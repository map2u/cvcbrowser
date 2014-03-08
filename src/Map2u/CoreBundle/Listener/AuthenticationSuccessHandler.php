<?php
namespace Map2u\CoreBundle\Listener;
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Http\Authentication\DefaultAuthenticationSuccessHandler;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class AuthenticationSuccessHandler extends DefaultAuthenticationSuccessHandler
{
   public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        if(true === $request->isXmlHttpRequest()) {
           return new JsonResponse(array('success' => true, 'status' => 'ok'));
        }
       
        //default redirect operation.
        return parent::onAuthenticationSuccess($request, $token);
    }

}
?>
