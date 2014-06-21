<?php

namespace Syngular\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class AbstractController extends \FOS\RestBundle\Controller\FOSRestController
{
    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    protected function getRepository() {
        return $this->getDoctrine()->getRepository('SyngularBackendBundle:' . $this->getRepositoryName());
    }
    
    protected function parseClassname($name) {
      return array(
        'namespace' => array_slice(explode('\\', $name), 0, -1),
        'classname' => join('', array_slice(explode('\\', $name), -1)),
      );
    }
    
    protected function getRepositoryName() {
        $name = $this->parseClassname(get_called_class())['classname'];
        return str_replace("Controller", "", $name);
    }
}
