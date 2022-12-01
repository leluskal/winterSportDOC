<?php
declare(strict_types=1);

namespace App\AdminModule\Components\Forms\RacePoint;

use App\Model\Repositories\DisciplineRepository;
use App\Model\Repositories\RacePointRepository;

class RacePointFormFactory
{

    private DisciplineRepository $disciplineRepository;

    private RacePointRepository $racePositionRepository;

    public function __construct(
        DisciplineRepository $disciplineRepository,
        RacePointRepository $racePositionRepository
    )
    {
        $this->disciplineRepository = $disciplineRepository;
        $this->racePositionRepository = $racePositionRepository;
    }

    public function create(): RacePointForm
    {
        return new RacePointForm($this->disciplineRepository, $this->racePositionRepository);
    }

}