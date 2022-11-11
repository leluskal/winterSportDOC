<?php
declare(strict_types=1);

namespace App\Model\Repositories;

use App\Model\Entities\Athlete\Athlete;

/**
 * @method Athlete|null getById(int $id)
 * @method Athlete save(Athlete $entity)
 */
class AthleteRepository extends BaseRepository
{
    protected function getEntityName(): string
    {
        return Athlete::class;
    }

    public function findAll(): array
    {
        return $this->em->createQueryBuilder()
            ->select('e')
            ->from($this->entityName, 'e')
            ->getQuery()
            ->getResult();
    }
}