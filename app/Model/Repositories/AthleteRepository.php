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

    /**
     * @return Athlete[]
     */
    public function findAll(): array
    {
        return $this->em->createQueryBuilder()
            ->select('e')
            ->from($this->entityName, 'e')
            ->getQuery()
            ->getResult();
    }

    public function findAllBySportIdAndGenderId(int $sportId, int $genderId): array
    {
        return $this->em->createQueryBuilder()
            ->select('e')
            ->from($this->entityName, 'e')
            ->andWhere('e.sport = :sport_id')
            ->setParameter('sport_id', $sportId)
            ->andWhere('e.gender = :gender_id')
            ->setParameter('gender_id', $genderId)
            ->orderBy('e.firstname', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findAllForSelectBoxBySportIdAndGenderId(int $sportId, int $genderId): array
    {
        $athletes = $this->findAllBySportIdAndGenderId($sportId, $genderId);

        $returnArray = [];

        foreach ($athletes as $athlete) {
            $returnArray[$athlete->getId()] = $athlete->getFirstname() . '  ' . $athlete->getLastname() . ' - ' . $athlete->getCountry();
        }

        return $returnArray;
    }

    public function findAllBySportId(int $sportId): array
    {
        return $this->em->createQueryBuilder()
            ->select('e')
            ->from($this->entityName, 'e')
            ->Where('e.sport = :sport_id')
            ->setParameter('sport_id', $sportId)
            ->getQuery()
            ->getResult();
    }
}