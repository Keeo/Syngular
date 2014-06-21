<?php

namespace Syngular\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class AbstractController extends \FOS\RestBundle\Controller\FOSRestController
{
    /**
     * @param type $name
     * @return \Doctrine\ORM\EntityRepository
     */
    protected function getRepository($name = null) {
        if (is_null($name)) {
            $name = $this->parseClassname(get_called_class())['classname'];
            $name = str_replace("Controller", "", $name);
        }
        return $this->getDoctrine()->getRepository('SyngularBackendBundle:'.$name);
    }
    
    protected function parseClassname($name)
    {
      return array(
        'namespace' => array_slice(explode('\\', $name), 0, -1),
        'classname' => join('', array_slice(explode('\\', $name), -1)),
      );
    }
}
