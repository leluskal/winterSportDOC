<?php
declare(strict_types=1);

namespace App\AdminModule\Components\Forms\RaceResult;

use App\Model\Repositories\AthleteRepository;
use App\Model\Repositories\DisciplineRepository;
use App\Model\Repositories\RacePositionRepository;
use App\Model\Repositories\RaceResultRepository;
use App\Model\Repositories\ScheduleRepository;

class RaceResultFormFactory
{
    private AthleteRepository $athleteRepository;

    private RacePositionRepository $racePositionRepository;

    private RaceResultRepository $raceResultRepository;

    private ScheduleRepository $scheduleRepository;

    private DisciplineRepository $disciplineRepository;

    public function __construct(
        AthleteRepository $athleteRepository,
        RacePositionRepository $racePositionRepository,
        RaceResultRepository $raceResultRepository,
        ScheduleRepository $scheduleRepository,
        DisciplineRepository $disciplineRepository
    )
    {
        $this->athleteRepository = $athleteRepository;
        $this->racePositionRepository = $racePositionRepository;
        $this->raceResultRepository = $raceResultRepository;
        $this->scheduleRepository = $scheduleRepository;
        $this->disciplineRepository = $disciplineRepository;
    }

    public function create(int $scheduleId): RaceResultForm
    {
        $schedule = $this->scheduleRepository->getById($scheduleId);

        return new RaceResultForm(
            $this->athleteRepository,
            $this->racePositionRepository,
            $this->raceResultRepository,
            $this->scheduleRepository,
            $this->disciplineRepository,
            $schedule
        );
    }
}