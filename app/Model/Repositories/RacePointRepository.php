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

    public function findAllForSelectBoxByDisciplineId(int $disciplineId): array
    {
        $racePoints = $this->findAllByDisciplineId($disciplineId);

        $returnArray = [];

        foreach ($racePoints as $racePoint) {
            $racePointId = $racePoint->getId();
            $point = $racePoint->getPosition() . '. (' . $racePoint->getPoints() . ' points)';
            $returnArray[$racePointId] = $point;
        }

        return $returnArray;
    }

    /**
     * @param int $sportId
     * @return RacePoint[]
     */
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

    public function findAllForSelectBoxBySportId(int $sportId): array
    {
        $racePoints = $this->findAllBySportId($sportId);

        $returnArray = [];

        foreach ($racePoints as $racePoint) {
            $racePointId = $racePoint->getId();
            $point = $racePoint->getPosition() . '. (' . $racePoint->getPoints() . ' points)';
            $returnArray[$racePointId] = $point;
        }

        return $returnArray;
    }
}