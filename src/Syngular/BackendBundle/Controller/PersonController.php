<?php

/**
 * @author Martin Morávek
 * @email moravek.martin@gmail.com
 */
namespace Syngular\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use FOS\RestBundle\Controller\Annotations\View as Rest;
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

class PersonController extends AbstractController
{
    /**
     * @Route("/people", name="people_get")
     * @Method("GET")
     */
    public function allAction()
    {
        $people = $this->getRepository()->findAll();
        $view = $this->view($people, 200)->setFormat("json");
        return $view;
    }
    
    /**
     * @Route("/people/{id}")
     * @Method("GET")
     */
    public function oneAction(Person $person)
    {
        $view = $this->view($person, 200)->setFormat("json");
        return $view;
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
    
    
    
    private function processForm(Person $person)
    {
        $statusCode = $person->getId() ? 201 : 204;

        $validator = $this->get('validator');
        $errors = $validator->validate($person);

        if (!count($errors)) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($person);
            $em->flush();
            
            $response = new Response();
            $response->setStatusCode($statusCode);
            $response->headers->set('Location',
                $this->generateUrl(
                    'people_get', array('id' => $person->getId()),
                    true
                )
            );

            return $response;
        }
        // well fuck
        //return $this->view($form, 400);
    }
    
    /**
     * @Rest/View(statusCode=204)
     * @Route("/people/{id}")
     * @Method("DELETE")
     */
    public function deleteAction(Person $person)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($person);
        $em->flush();

        $response = new Response();
        $response->setStatusCode(204);
        return $response;
    }
}
