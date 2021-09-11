<?php

declare(strict_types=1);

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserDataPersister implements DataPersisterInterface
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var UserPasswordEncoderInterface */
    private $encoder;

    public function __construct(
        EntityManagerInterface $entityManager,
        UserPasswordEncoderInterface $encoder
    ) {
        $this->entityManager = $entityManager;
        $this->encoder = $encoder;
    }

    /** @param object $data */
    public function supports($data): bool
    {
        return $data instanceof User;
    }

    /** @param object $data */
    public function persist($data): void
    {
        if ($data->getPassword()) {
            $data->setPassword($this->encoder->encodePassword($data, $data->getPassword()));
        }

        $this->entityManager->persist($data);
        $this->entityManager->flush();
    }

    /** @param object $data */
    public function remove($data): void
    {
        $this->entityManager->remove($data);
        $this->entityManager->flush();
    }
}
