<?php

declare(strict_types=1);

namespace App\DataFixtures;

use Faker\Factory as FakerGeneratorFactory;
use Faker\Generator;
use Nelmio\Alice\Faker\Provider\AliceProvider;
use Nelmio\Alice\Loader\NativeLoader;

class CustomNativeLoader extends NativeLoader
{
    private const OVERRIDDEN_LOCALE = 'es_ES';

    protected function createFakerGenerator(): Generator
    {
        $generator = FakerGeneratorFactory::create(self::OVERRIDDEN_LOCALE);
        $generator->addProvider(new AliceProvider());
        $generator->addProvider(new CustomFixtureLoader());
        $generator->seed($this->getSeed());

        return $generator;
    }
}
