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
    FOS\RestBundle\Request\ParamFetcher,
    FOS\RestBundle\Controller\Annotations as Rest,
    FOS\RestBundle\Controller\Annotations\RequestParam,
    FOS\RestBundle\Controller\Annotations\QueryParam;

use Syngular\BackendBundle\Entity\Person,
    Syngular\BackendBundle\Form\PersonType,
    Syngular\BackendBundle\Entity\Injection;

class PersonController extends AbstractController
{
    /**
     * @Route("/people", name="people_get")
     * @Method("GET")
     * @Rest\View
     */
    public function allAction()
    {
        $people = $this->getRepository()->findAll();
        return ["people"=>$people];
    }
    
    /**
     * @Route("/people/{id}")
     * @Method("GET")
     * @Rest\View
     */
    public function oneAction(Person $person)
    {
        return ["people"=>$person];
    }
    
    /**
     * @ParamConverter("person", converter="fos_rest.request_body")
     * @Route("/people")
     * @Method("POST")
     */
    public function newAction(Request $request, Person $person) 
    {
        return $this->processForm($request, $person);
    }
    
    /**
     * @Route("/people/{person}")
     * @Method("PUT")
     */
    public function putAction(Request $request, Person $person) 
    {
        return $this->processForm($request, $person);
    }
    
    private function processForm(Request $request, Person $person)
    {
        $statusCode = $person->getId() ? 201 : 204;

        $form = $this->createForm(new PersonType, $person);
        $form->submit($request);
        
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            if (!$person->getId()) {
                $em->persist($person);
            } else {
                $em->merge($person);
            }
            $em->flush();

            $response = new Response();
            $response->setStatusCode($statusCode);

            if (201 === $statusCode) {
                $response->headers->set('Location',
                    $this->generateUrl(
                        'people_get', array('id' => $person->getId()),
                        true
                    )
                );
            }

            return $response;
        }

        return View::create($form, 400);
    }
    
    /**
     * @Route("/people/{id}")
     * @Method("DELETE")
     * @Rest\View(statusCode=204)
     */
    public function deleteAction(Person $person)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($person);
        $em->flush();
    }
    
    /**
     * @Route("/people/{id}/injections")
     * @Method("GET")
     * @Rest\View
     */
    public function getInjectionsAction(Person $person)
    {
        return ['injections'=>$person->getInjections()];
    }
    
    /**
     * @Route("/people/{id}/injection")
     * @Method("LINK")
     * @Rest\View(statusCode=204)
     */
    public function linkAction(Person $person, Request $request)
    {
        if (!$request->attributes->has('links')) {
            throw new HttpException(400);
        }

        foreach ($request->attributes->get('links') as $i) {
            if (!$i instanceof Injection) {
                throw new NotFoundHttpException('Invalid resource');
            }

            if ($person->getInjections()->contains($i)) {
                throw new HttpException(409, 'Users are already friends');
            }
            
            $person->addInjection($i);
            $i->setPerson($person);
        }
        $em = $this->getDoctrine()->getManager();
        $em->persist($person);
        $em->flush();
    }
}
