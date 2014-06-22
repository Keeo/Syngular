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
    Syngular\BackendBundle\Form\PersonType,
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
}
