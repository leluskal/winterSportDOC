<?php
declare(strict_types=1);

namespace App\Model\Repositories;

use App\Model\Entities\RacePosition\RacePosition;

/**
 * @method RacePosition|null getById(int $id)
 * @method RacePosition save(RacePosition $entity)
 */
class RacePositionRepository extends BaseRepository
{
    protected function getEntityName(): string
    {
        return RacePosition::class;
    }

    /**
     * @return RacePosition[]
     */
    public function findAll(): array
    {
        return $this->em->createQueryBuilder()
            ->select('e')
            ->from($this->entityName, 'e')
            ->getQuery()
            ->getResult();
    }

    public function findAllBySportId(int $sportId): array
    {
        return $this->em->createQueryBuilder()
            ->select('e')
            ->from($this->entityName, 'e')
            ->where('e.sport = :sport_id')
            ->setParameter('sport_id', $sportId)
            ->getQuery()
            ->getResult();
    }
}