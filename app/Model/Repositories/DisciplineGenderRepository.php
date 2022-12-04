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

    public function findAllBySportId(int $sportId): array
    {
        return $this->em->createQueryBuilder()
            ->select('e')
            ->from($this->entityName, 'e')
            ->leftJoin('e.discipline', 'd')
            ->leftJoin('d.sport', 's')
            ->where('s.id = :sport_id')
            ->setParameter('sport_id', $sportId)
            ->getQuery()
            ->getResult();
    }

    public function findAllBySportIdAndGenderId(int $sportId, int $genderId): array
    {
        return $this->em->createQueryBuilder()
            ->select('e')
            ->from($this->entityName, 'e')
            ->leftJoin('e.discipline', 'd')
            ->leftJoin('d.sport', 's')
            ->andWhere('s.id = :sport_id')
            ->setParameter('sport_id', $sportId)
            ->andWhere('e.gender = :gender_id')
            ->setParameter('gender_id', $genderId)
            ->getQuery()
            ->getResult();
    }

    public function findAllForSelectBoxBySportId(int $sportId): array
    {
        $disciplineGenders = $this->findAllBySportId($sportId);

        $returnArray = [];

        foreach ($disciplineGenders as $disciplineGender) {
            $record = $disciplineGender->getDiscipline()->getName() . ' (' . $disciplineGender->getGender()->getName() . ')';
            $returnArray[$disciplineGender->getId()] = $record;
        }

        return $returnArray;
    }
}