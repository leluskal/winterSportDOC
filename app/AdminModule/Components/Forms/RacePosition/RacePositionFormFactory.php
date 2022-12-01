<?php
declare(strict_types=1);

namespace App\AdminModule\Components\Forms\RacePosition;

use App\Model\Repositories\DisciplineRepository;
use App\Model\Repositories\RacePositionRepository;
use App\Model\Repositories\SportRepository;

class RacePositionFormFactory
{
    private SportRepository $sportRepository;

    private DisciplineRepository $disciplineRepository;

    private RacePositionRepository $racePositionRepository;

    public function __construct(
        SportRepository $sportRepository,
        DisciplineRepository $disciplineRepository,
        RacePositionRepository $racePositionRepository
    )
    {
        $this->sportRepository = $sportRepository;
        $this->disciplineRepository = $disciplineRepository;
        $this->racePositionRepository = $racePositionRepository;
    }

    public function create(): RacePositionForm
    {
        return new RacePositionForm($this->sportRepository, $this->disciplineRepository, $this->racePositionRepository);
    }

}