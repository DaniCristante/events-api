<?php

declare(strict_types=1);

namespace App\DataFixtures;

class CustomFixtureLoader
{
    private const EMAIL_DOMAINS = [
        '@gmail.com',
        '@gmail.es',
        '@outlook.com',
        '@hotmail.com',
        '@yahoo.es',
    ];

    public function customEmail(string $name, string $surname): string
    {
        $name = $this->removeSpaces($name);

        return $this->stripAccents(strtolower($name)) . '_'
            . $this->stripAccents(strtolower($surname)) . random_int(99, 999) . self::EMAIL_DOMAINS[rand(0, 4)];
    }

    public function customNickname(string $name, string $surname): string
    {
        $name = strtolower($name);

        if (str_contains($name, ' ')) {
            $compoundName = explode(' ', $name);
            $name = $compoundName[0];
        }

        return $this->stripAccents($name) . $this->stripAccents($surname) . random_int(100, 999);
    }

    private function stripAccents($str)
    {
        return strtr(utf8_decode($str), utf8_decode('àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ'), 'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
    }

    private function removeSpaces(string $name): string
    {
        return str_replace(' ', '_', $name);
    }
}
