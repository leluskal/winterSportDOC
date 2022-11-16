<?php
declare(strict_types=1);

namespace App\Model\Repositories;

use App\Model\Entities\RaceResult\RaceResult;

/**
 * @method RaceResult|null getById(int $id)
 * @method RaceResult save(RaceResult $entity)
 */
class RaceResultRepository extends BaseRepository
{
    protected function getEntityName(): string
    {
        return RaceResult::class;
    }

    /**
     * @return RaceResult[]
     */
    public function findAll(): array
    {
        return $this->em->createQueryBuilder()
            ->select('e')
            ->from($this->entityName, 'e')
            ->getQuery()
            ->getResult();
    }
}