<?php
declare(strict_types=1);

namespace App\Model\Repositories;

use App\Model\Entities\RaceEvent\RaceEvent;

/**
 * @method RaceEvent|null getById(int $id)
 * @method RaceEvent save(RaceEvent $entity)
 */
class RaceEventRepository extends BaseRepository
{
    protected function getEntityName(): string
    {
        return RaceEvent::class;
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

    /**
     * @return RaceEvent[]
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
        $raceEvents = $this->findAll();

        $returnArray = [];

        foreach ($raceEvents as $raceEvent) {
            $returnArray[$raceEvent->getId()] = $raceEvent->getVenue();
        }

        return $returnArray;
    }
}