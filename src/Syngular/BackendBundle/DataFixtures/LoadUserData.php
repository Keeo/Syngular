<?php

namespace Syngular\BackendBundle\DataFixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Syngular\BackendBundle\Entity\Person;

class LoadPersonData extends AbstractFixture implements OrderedFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $p = new Person;
        $p->setName("Karel");
        $manager->persist($p);
        
        $p = new Person;
        $p->setName("Honza");
        $manager->persist($p);
        
        $p = new Person;
        $p->setName("Jonas");
        $manager->persist($p);
        
        $p = new Person;
        $p->setName("Sarka");
        $manager->persist($p);
        
        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}