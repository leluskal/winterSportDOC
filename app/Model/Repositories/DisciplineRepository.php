<?php
declare(strict_types=1);

namespace App\Model\Repositories;

use App\Model\Entities\Discipline\Discipline;

/**
 * @method Discipline|null getById(int $id)
 * @method Discipline save(Discipline $entity)
 */
class DisciplineRepository extends BaseRepository
{
    protected function getEntityName(): string
    {
        return Discipline::class;
    }

    /**
     * @return Discipline[]
     */
    public function findAll(): array
    {
        return $this->em->createQueryBuilder()
            ->select('e')
            ->from($this->entityName, 'e')
            ->getQuery()
            ->getResult();
    }

    public function findAllForSelectBox(): array
    {
        $disciplines = $this->findAll();

        $returnArray = [];

        foreach ($disciplines as $discipline) {
            $disciplineId = $discipline->getId();
            $discipline = $discipline->getSport()->getName() . ' - ' . $discipline->getName() . '(' . $discipline->getGender()->getName() . ')';
            $returnArray[$disciplineId] = $discipline;
        }

        return $returnArray;
    }
}