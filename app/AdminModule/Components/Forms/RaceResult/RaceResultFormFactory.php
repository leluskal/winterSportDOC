<?php
declare(strict_types=1);

namespace App\AdminModule\Components\Forms\RaceResult;

use App\Model\Repositories\AthleteRepository;
use App\Model\Repositories\RacePositionRepository;
use App\Model\Repositories\RaceResultRepository;
use App\Model\Repositories\ScheduleRepository;

class RaceResultFormFactory
{
    private ScheduleRepository $scheduleRepository;

    private AthleteRepository $athleteRepository;

    private RacePositionRepository $racePositionRepository;

    private RaceResultRepository $raceResultRepository;

    public function __construct(
        ScheduleRepository $scheduleRepository,
        AthleteRepository $athleteRepository,
        RacePositionRepository $racePositionRepository,
        RaceResultRepository $raceResultRepository
    )
    {
        $this->scheduleRepository = $scheduleRepository;
        $this->athleteRepository = $athleteRepository;
        $this->racePositionRepository = $racePositionRepository;
        $this->raceResultRepository = $raceResultRepository;
    }

    public function create(): RaceResultForm
    {
        return new RaceResultForm(
            $this->scheduleRepository,
            $this->athleteRepository,
            $this->racePositionRepository,
            $this->raceResultRepository
        );
    }
}