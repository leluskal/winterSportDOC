<?php
declare(strict_types=1);

namespace App\AdminModule\Components\Forms\RaceEvent;

use App\Model\Repositories\RaceEventRepository;
use App\Model\Repositories\ScheduleRepository;

class RaceEventFormFactory
{
    private ScheduleRepository $scheduleRepository;

    private RaceEventRepository $raceEventRepository;

    public function __construct(ScheduleRepository $scheduleRepository, RaceEventRepository $raceEventRepository)
    {
        $this->scheduleRepository = $scheduleRepository;
        $this->raceEventRepository = $raceEventRepository;
    }

    public function create(): RaceEventForm
    {
        return new RaceEventForm($this->scheduleRepository, $this->raceEventRepository);
    }
}