<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Database\Persistence\Doctrine;

use App\Shared\Domain\Entity\Aggregate;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

abstract class DoctrineRepository
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    protected function entityManager(): EntityManagerInterface
    {
        return $this->entityManager;
    }

    protected function persist(Aggregate $entity): void
    {
        $this->entityManager()->persist($entity);
        $this->entityManager()->flush();
    }

    protected function remove(Aggregate $entity): void
    {
        $this->entityManager()->remove($entity);
        $this->entityManager()->flush();
    }

    protected function repository(string $entityClass): EntityRepository
    {
        /* @phpstan-ignore-next-line */
        return $this->entityManager->getRepository($entityClass);
    }
}
