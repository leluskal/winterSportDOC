<?php
declare(strict_types=1);

namespace App\Model\Repositories;

use App\Model\Entities\RacePoint\RacePoint;

/**
 * @method RacePoint|null getById(int $id)
 * @method RacePoint save(RacePoint $entity)
 */
class RacePointRepository extends BaseRepository
{
    protected function getEntityName(): string
    {
        return RacePoint::class;
    }

    /**
     * @return RacePoint[]
     */
    public function findAll(): array
    {
        return $this->em->createQueryBuilder()
            ->select('e')
            ->from($this->entityName, 'e')
            ->getQuery()
            ->getResult();
    }

    public function findAllByDisciplineId(int $disciplineId): array
    {
        return $this->em->createQueryBuilder()
            ->select('e')
            ->from($this->entityName, 'e')
            ->where('e.discipline = :discipline_id')
            ->setParameter('discipline_id', $disciplineId)
            ->getQuery()
            ->getResult();
    }
}