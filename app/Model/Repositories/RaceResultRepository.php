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

    public function findAllByDisciplineId(int $disciplineId): array
    {
        return $this->em->createQueryBuilder()
            ->select('e')
            ->from($this->entityName, 'e')
            ->leftJoin('e.schedule', 's')
            ->leftJoin('s.discipline', 'd')
            ->andWhere('d.id = :discipline_id')
            ->setParameter('discipline_id', $disciplineId)
            ->getQuery()
            ->getResult();
    }

    public function findAllByScheduleId(int $scheduleId): array
    {
        return $this->em->createQueryBuilder()
            ->select('e')
            ->from($this->entityName, 'e')
            ->where('e.schedule = :schedule_id')
            ->setParameter('schedule_id', $scheduleId)
            ->getQuery()
            ->getResult();
    }

    public function getTotalResultsBySportIdAndGenderId(int $sportId, int $genderId)
    {
        return $this->em->createQueryBuilder()
            ->select('a.firstname, a.lastname, SUM(rp.point) as totalPoints')
            ->from($this->entityName, 'e')
            ->leftJoin('e.schedule', 's')
            ->leftJoin('s.sport', 'sp')
            ->leftJoin('e.racePoint', 'rp')
            ->leftJoin('e.athlete', 'a')
            ->leftJoin('a.gender', 'g')
            ->andWhere('sp.id = :sport_id')
            ->setParameter('sport_id', $sportId)
            ->andWhere('g.id = :gender_id')
            ->setParameter('gender_id', $genderId)
            ->groupBy('a.id')
            ->orderBy('totalPoints', 'DESC')
            ->getQuery()
            ->getResult();
    }


    public function getTotalResultsByDisciplineId(int $disciplineId, int $genderId)
    {
        return $this->em->createQueryBuilder()
            ->select('a.firstname, a.lastname, SUM(rp.point) as totalPoints')
            ->from($this->entityName, 'e')
            ->leftJoin('e.schedule', 's')
            ->leftJoin('s.discipline', 'd')
            ->leftJoin('e.racePoint', 'rp')
            ->leftJoin('e.athlete', 'a')
            ->leftJoin('a.gender', 'g')
            ->andWhere('d.id = :discipline_id')
            ->setParameter('discipline_id', $disciplineId)
            ->andWhere('g.id = :gender_id')
            ->setParameter('gender_id', $genderId)
            ->groupBy('a.id')
            ->orderBy('totalPoints', 'DESC')
            ->getQuery()
            ->getResult();
    }
}