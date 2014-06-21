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
        $p->setAddress("Karlova 44, Praha 7");
        $manager->persist($p);
        
        $p = new Person;
        $p->setName("Honza");
        $p->setAddress("Janova 44, Brno 25");
        $manager->persist($p);
        
        $p = new Person;
        $p->setName("Jonas");
        $p->setAddress("Irak 44, Vybuch");
        $manager->persist($p);
        
        $p = new Person;
        $p->setName("Sarka");
        $p->setAddress("Na sluji, Zima 8");
        $manager->persist($p);
        
        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}