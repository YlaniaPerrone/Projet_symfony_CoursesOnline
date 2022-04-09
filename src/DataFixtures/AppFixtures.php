<?php

namespace App\DataFixtures;

use App\Entity\Language;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

    $list = ['français', 'anglais', 'espagnol'];
        for ($i = 0; $i < count($list); $i++) {
//
            $langue = new Language();
            $langue->setName($list[$i]);
            $manager->persist($langue);
        }
//
        $manager->flush();

        $manager->flush();
    }
}
