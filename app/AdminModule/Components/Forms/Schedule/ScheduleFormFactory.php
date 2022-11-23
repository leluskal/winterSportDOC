<?php
declare(strict_types=1);

namespace App\AdminModule\Components\Forms\Schedule;

use App\Model\Repositories\DisciplineRepository;
use App\Model\Repositories\ScheduleRepository;
use App\Model\Repositories\SportRepository;

class ScheduleFormFactory
{
    private SportRepository $sportRepository;

    private DisciplineRepository $disciplineRepository;

    private ScheduleRepository $scheduleRepository;

    public function __construct(
        SportRepository $sportRepository,
        DisciplineRepository $disciplineRepository,
        ScheduleRepository $scheduleRepository
    )
    {
        $this->sportRepository = $sportRepository;
        $this->disciplineRepository = $disciplineRepository;
        $this->scheduleRepository = $scheduleRepository;
    }

    public function create(): ScheduleForm
    {
        return new ScheduleForm($this->sportRepository, $this->disciplineRepository, $this->scheduleRepository);
    }
}