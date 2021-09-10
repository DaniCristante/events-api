<?php

declare(strict_types=1);

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $loader = new CustomNativeLoader();
        $objects = $loader->loadFile(__DIR__ . '/Fixtures/fixtures.yml')->getObjects();

        foreach ($objects as $object) {
            $manager->persist($object);
        }

        $manager->flush();
    }
}
