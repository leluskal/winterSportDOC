<?php
declare(strict_types=1);

namespace App\Model\Repositories;

use App\Model\Entities\Sport\Sport;

/**
 * @method Sport|null getById(int $id)
 * @method Sport save(Sport $entity)
 */
class SportRepository extends BaseRepository
{
    protected function getEntityName(): string
    {
        return Sport::class;
    }

    /**
     * @return Sport[]
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