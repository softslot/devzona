<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Doctrine;

use Doctrine\ORM\EntityManagerInterface;

class AppEntityManager
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    /** @param object[] $entities */
    public function detachEntities(array $entities): void
    {
        foreach ($entities as $entity) {
            $this->entityManager->detach($entity);
        }
    }

    public function persist(object $entity): void
    {
        $this->entityManager->persist($entity);
    }

    public function flush(): void
    {
        $this->entityManager->flush();
    }

    public function save(object $entity): void
    {
        $this->persist($entity);
        $this->flush();
    }

    public function clear(): void
    {
        $this->entityManager->clear();
    }
}
