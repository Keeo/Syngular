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

use Syngular\BackendBundle\Entity\Injection;

class InjectionController extends AbstractController
{
    /**
     * @Route("/injection/{id}")
     * @Method("GET")
     * @Rest\View
     */
    public function oneAction(Injection $injection)
    {
        return [$injection];
    }
}
