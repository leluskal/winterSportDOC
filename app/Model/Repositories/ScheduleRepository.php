<?php
declare(strict_types=1);

namespace App\Model\Repositories;

use App\Model\Entities\Schedule\Schedule;

/**
 * @method Schedule|null getById(int $id)
 * @method Schedule save(Schedule $entity)
 */
class ScheduleRepository extends BaseRepository
{
    protected function getEntityName(): string
    {
        return Schedule::class;
    }

    /**
     * @return Schedule[]
     */
    public function findAll(): array
    {
        return $this->em->createQueryBuilder()
            ->select('e')
            ->from($this->entityName, 'e')
            ->orderBy('e.eventDate', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findAllForSelectBox(): array
    {
        $schedules = $this->findAll();

        $returnArray = [];

        foreach ($schedules as $schedule) {
            $scheduleId = $schedule->getId();
            $schedule = $schedule->getDisciplineGender()->getName() . ' - ' .
                        $schedule->getDisciplineGender()->getGender()->getName() .' - ' .
                        $schedule->getEventDate()->format('d.m.Y H:i') . ' - ' .
                        $schedule->getEventPlace();

            $returnArray[$scheduleId] = $schedule;
        }

        return $returnArray;
    }

    /**
     * @param int $year
     * @return Schedule[]
     */
    public function findAllByYear(int $year): array
    {
        return $this->em->createQueryBuilder()
            ->select('e')
            ->from($this->entityName, 'e')
            ->where('e.year = :year')
            ->setParameter('year', $year)
            ->orderBy('e.eventDate', 'ASC')
            ->getQuery()
            ->getResult();
    }


    public function findAllGroupedByDate(int $year): array
    {
        $schedules = $this->findAllByYear($year);

        $returnArray = [];

        foreach ($schedules as $schedule) {
            $date = $schedule->getEventDate()->format('d.m.Y');
            $returnArray[$date][] = $schedule;
        }

        return $returnArray;
    }

    /**
     * @param int $sportId
     * @return Schedule[]
     */
    public function findAllBySportId(int $sportId): array
    {
        return $this->em->createQueryBuilder()
            ->select('e')
            ->from($this->entityName, 'e')
            ->where('e.sport = :sport_id')
            ->setParameter('sport_id', $sportId)
            ->orderBy('e.eventDate', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @param int $sportId
     * @param int $year
     * @return Schedule[]
     */
    public function findAllBySportIdAndYear(int $sportId, int $year): array
    {
        return $this->em->createQueryBuilder()
            ->select('e')
            ->from($this->entityName, 'e')
            ->where('e.sport = :sport_id')
            ->setParameter('sport_id', $sportId)
            ->andWhere('e.year = :year')
            ->setParameter('year', $year)
            ->orderBy('e.eventDate', 'ASC')
            ->getQuery()
            ->getResult();
    }


    public function findAllForSelectBoxBySportId(int $sportId): array
    {
        $schedules = $this->findAllBySportId($sportId);

        $returnArray = [];

        foreach ($schedules as $schedule) {
            $scheduleId = $schedule->getId();
            $schedule = $schedule->getDisciplineGender()->getDiscipline()->getName() . '(' . $schedule->getDisciplineGender()->getGender()->getName() . ')';
            $returnArray[$scheduleId] = $schedule;
        }

        return $returnArray;
    }

    /**
     * @param int $disciplineId
     * @return Schedule[]
     */
    public function findAllByDisciplineIdAndGenderId(int $disciplineId, int $genderId): array
    {
        return $this->em->createQueryBuilder()
            ->select('e')
            ->from($this->entityName, 'e')
            ->leftJoin('e.disciplineGender', 'dg')
            ->where('dg.discipline = :discipline_id')
            ->setParameter('discipline_id', $disciplineId)
            ->andWhere('dg.gender = :gender_id')
            ->setParameter('gender_id', $genderId)
            ->orderBy('e.eventDate', 'ASC')
            ->getQuery()
            ->getResult();
    }
}