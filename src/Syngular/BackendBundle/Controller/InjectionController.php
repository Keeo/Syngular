<?php

/**
 * @author Martin Morávek
 * @email moravek.martin@gmail.com
 */
namespace Syngular\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Symfony\Component\HttpFoundation\Request,
    Symfony\Component\HttpKernel\Exception\NotFoundHttpException,
    Symfony\Component\HttpFoundation\Response,
    Symfony\Component\HttpKernel\Exception\HttpException;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Template,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Method,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use FOS\RestBundle\View\View,
    FOS\RestBundle\Controller\Annotations as Rest,
    FOS\RestBundle\Request\ParamFetcher,
    FOS\RestBundle\Controller\Annotations\RequestParam,
    FOS\RestBundle\Controller\Annotations\QueryParam;

use Syngular\BackendBundle\Entity\Person,
    Syngular\BackendBundle\Form\InjectionType,
    Syngular\BackendBundle\Entity\Injection;

class InjectionController extends AbstractController
{
    /**
     * @Route("/injection/{id}")
     * @Method("GET")
     * @Rest\View
     */
    public function oneAction(Injection $injection)
    {
        return ["injection"=>$injection];
    }
    
    /**
     * @Route("/injection", name="injection_get")
     * @Method("GET")
     * @Rest\View
     */
    public function allAction()
    {
        $injection = $this->getRepository()->findAll();
        return ["injection"=>$injection];
    }
    
    /**
     * @ParamConverter("injection", converter="fos_rest.request_body")
     * @Route("/people/{person}/injection")
     * @Route("/injection", defaults={"person" = null})
     * @Method("POST")
     */
    public function newAction(Request $request, Injection $injection, Person $person = null) 
    {
        if ($person) {
            $injection->setPerson($person);
        }
        return $this->processForm($request, $injection);
    }
    
    /**
     * @Route("/injection/{injection}")
     * @Method("PUT")
     */
    public function putAction(Request $request, Injection $injection) 
    {
        return $this->processForm($request, $injection);
    }
    
    private function processForm(Request $request, Injection $injection)
    {
        $statusCode = $injection->getId() ? 201 : 204;

        $form = $this->createForm(new InjectionType(), $injection);
        $form->submit($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            if (!$injection->getId()) {
                $em->persist($injection);
            } else {
                $em->merge($injection);
            }
            $em->flush();

            $response = new Response();
            $response->setStatusCode($statusCode);

            if (201 === $statusCode) {
                $response->headers->set('Location',
                    $this->generateUrl(
                        'injection_get', array('id' => $injection->getId()),
                        true
                    )
                );
            }

            return $response;
        }

        return View::create($form, 400);
    }
}
