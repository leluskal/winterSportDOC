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
            ->getQuery()
            ->getResult();
    }

    public function findAllForSelectBox(): array
    {
        $schedules = $this->findAll();

        $returnArray = [];

        foreach ($schedules as $schedule) {
            $scheduleId = $schedule->getId();
            $schedule = $schedule->getDiscipline()->getSport()->getName() . ' - ' .
                        $schedule->getDiscipline()->getName() . ' - ' .
                        $schedule->getDiscipline()->getGender()->getName() .' - ' .
                        $schedule->getEventDate()->format('d.m.Y H:i') . ' - ' .
                        $schedule->getEventPlace();

            $returnArray[$scheduleId] = $schedule;
        }

        return $returnArray;
    }

    public function findAllGroupedByDate(): array
    {
        $schedules = $this->findAll();

        $returnArray = [];

        foreach ($schedules as $schedule) {
            $date = $schedule->getEventDate()->format('d.m.Y');
            $returnArray[$date][] = $schedule;
        }

        return $returnArray;
    }

    public function findAllBySportId(int $sportId): array
    {
        return $this->em->createQueryBuilder()
            ->select('e')
            ->from($this->entityName, 'e')
            ->where('e.sport = :sport_id')
            ->setParameter('sport_id', $sportId)
            ->getQuery()
            ->getResult();
    }
}