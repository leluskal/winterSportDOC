<?php
declare(strict_types=1);

namespace App\Model\Repositories;

use App\Model\Entities\DisciplineGender\DisciplineGender;

/**
 * @method DisciplineGender|null getById(int $id)
 * @method DisciplineGender save(DisciplineGender $entity)
 */
class DisciplineGenderRepository extends BaseRepository
{
    protected function getEntityName(): string
    {
        return DisciplineGender::class;
    }

    /**
     * @return DisciplineGender[]
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