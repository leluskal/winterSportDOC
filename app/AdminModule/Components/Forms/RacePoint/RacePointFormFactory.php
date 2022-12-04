<?php
declare(strict_types=1);

namespace App\AdminModule\Components\Forms\RacePoint;

use App\Model\Repositories\DisciplineRepository;
use App\Model\Repositories\RacePointRepository;

class RacePointFormFactory
{
    private DisciplineRepository $disciplineRepository;

    private RacePointRepository $racePointRepository;

    public function __construct(
        DisciplineRepository $disciplineRepository,
        RacePointRepository $racePointRepository
    )
    {
        $this->disciplineRepository = $disciplineRepository;
        $this->racePointRepository = $racePointRepository;
    }

    public function create(): RacePointForm
    {
        return new RacePointForm($this->disciplineRepository, $this->racePointRepository);
    }

}