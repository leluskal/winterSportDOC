<?php
declare(strict_types=1);

namespace App\Model\Repositories;

use App\Model\Entities\Gender\Gender;

/**
 * @method Gender|null getById(int $id)
 * @method Gender save(Gender $entity)
 */
class GenderRepository extends BaseRepository
{
    protected function getEntityName(): string
    {
        return Gender::class;
    }

    /**
     * @return Gender[]
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