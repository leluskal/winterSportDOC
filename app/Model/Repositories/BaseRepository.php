<?php
declare(strict_types=1);

namespace App\Model\Repositories;

use Doctrine\ORM\EntityManagerInterface;

abstract class BaseRepository
{
    protected EntityManagerInterface $em;

    protected string $entityName;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->entityName = $this->getEntityName();
    }

    abstract protected function getEntityName(): string;

    public function getById(int $id)
    {
        return $this->em->find($this->entityName, $id);
    }

    public function save($entity)
    {
        $this->em->persist($entity);
        $this->em->flush();
    }

    public function delete($entity): void
    {
        $this->em->remove($entity);
        $this->em->flush();
    }
}