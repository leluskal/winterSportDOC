<?php
declare(strict_types=1);

namespace App\Model\Repositories;

use App\Model\Entities\RaceEvent\RaceEvent;
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

    public function findAllForSelectBox(): array
    {
        $sports = $this->findAll();

        $returnArray = [];

        foreach ($sports as $sport) {
            $returnArray[$sport->getId()] = $sport->getName();
        }

        return $returnArray;
    }

    public function getByRaceEventId(int $raceEventId): ?Sport
    {
        /** @var RaceEvent $raceEvent */
        $raceEvent = $this->em->createQueryBuilder()
            ->select('r')
            ->from(RaceEvent::class, 'r')
            ->leftJoin('r.schedule', 'sc')
            ->leftJoin('sc.sport', 's')
            ->andWhere('r.id = :race_event_id')
            ->setParameter('race_event_id', $raceEventId)
            ->getQuery()
            ->getOneOrNullResult();


        return $raceEvent->getSchedule()->getSport();
    }
}