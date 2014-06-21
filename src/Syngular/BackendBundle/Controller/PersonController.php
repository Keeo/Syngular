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

class PersonController extends AbstractController
{
    /**
     * @Route("/people/")
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
     * @Route("/people/")
     * @Method("POST")
     */
    public function postAction(Person $person) 
    {
        
    }
    
    /**
     * @View(statusCode=204)
     * @Method("DELETE")
     */
    public function deleteAction(Person $person)
    {
        $this->getDoctrine()->getManager()->remove($person);
    }
}
