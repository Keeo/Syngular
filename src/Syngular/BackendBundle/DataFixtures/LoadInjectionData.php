<?php

namespace Syngular\BackendBundle\DataFixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Syngular\BackendBundle\Entity\Person;
use Syngular\BackendBundle\Entity\Injection;

class LoadInjectionData extends AbstractFixture implements OrderedFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $injection = new Injection;
        $injection->setCode("A6486GTFRD");
        $injection->setName("Huge head");
        $manager->persist($injection);
        $manager->flush();
        
        $this->addReference('injection', $injection);
    }

    public function getOrder()
    {
        return 1;
    }
}
