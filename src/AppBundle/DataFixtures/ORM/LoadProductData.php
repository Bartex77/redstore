<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Product;

class LoadProductData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $product = new Product();
        $product->setName('AGM-123 Skipper II - laser quided bomb');
        $manager->persist($product);

        $product = new Product();
        $product->setName('Vis wz. 35 - pistol');
        $manager->persist($product);

        $product = new Product();
        $product->setName('TWARDY PT-91 - tank');
        $manager->persist($product);

        $manager->flush();
    }
}
