<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $liste = ['informatique', 'science', 'marketing', 'politique', 'médecine'];
        for ($i = 0; $i < count($liste); $i++) {
//
            $category = new Category();
            $category->setName($liste[$i]);
            $manager->persist($category);
        }

        $manager->flush();
    }
}
