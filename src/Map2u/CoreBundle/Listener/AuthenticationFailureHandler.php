<?php

namespace Map2u\CoreBundle\Listener;
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Http\Authentication\DefaultAuthenticationFailureHandler;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

class AuthenticationFailureHandler extends DefaultAuthenticationFailureHandler
{
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        if(true === $request->isXmlHttpRequest()) {
             return new JsonResponse(array('success' => false, 'status' => 'failure','message'=>'Wrong user name or password!'));
        }
        //default redirect operation.
      //  echo $request->getLocale();
        if($request->getLocale() and strlen($request->getLocale())>0)
            $this->options['login_path']='/'.$request->getLocale().'/login';
        else {
             $this->options['login_path']='/login';
        }
        return parent::onAuthenticationFailure($request, $exception);

    }
}
?>
