<?php

/**
 * @author Martin Morávek
 * @email moravek.martin@gmail.com
 */
namespace Syngular\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Syngular\BackendBundle\Entity\Person;

use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use FOS\RestBundle\Controller\Annotations\QueryParam;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;
use Syngular\BackendBundle\Form\PersonType;

use Symfony\Component\HttpKernel\Exception\HttpException;
use Syngular\BackendBundle\Entity\Injection;

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
        return [$people];
    }
    
    /**
     * @Route("/people/{id}")
     * @Method("GET")
     * @Rest\View
     */
    public function oneAction(Person $person)
    {
        return [$person];
    }
    
    /**
     * @ParamConverter("person", converter="fos_rest.request_body")
     * @Route("/people")
     * @Method("POST")
     */
    public function newAction(Person $person) 
    {
        return $this->processForm($person);
    }
    
    /**
     * @ParamConverter("person", converter="fos_rest.request_body")
     * @Route("/people/{id}")
     * @Method("PUT")
     */
    public function putAction(Person $person, $id) 
    {
        $person->setId($id);
        return $this->processForm($person);
    }
    
    private function processForm(Person $person, Request $request = null)
    {
        $statusCode = $person->getId() ? 201 : 204;

        $form = $this->createForm(new PersonType(), $person);
        if ($request != null) {
            $form->handleRequest($request);
        }
        
        //if ($form->isValid()) {
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
        //}

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
     * @Route("/people/{id}")
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
