<?php
declare(strict_types=1);

namespace App\AdminModule\Components\Forms\Schedule;

use App\Model\Repositories\DisciplineRepository;
use App\Model\Repositories\ScheduleRepository;

class ScheduleFormFactory
{
    private DisciplineRepository $disciplineRepository;

    private ScheduleRepository $scheduleRepository;

    public function __construct(DisciplineRepository $disciplineRepository, ScheduleRepository $scheduleRepository)
    {
        $this->disciplineRepository = $disciplineRepository;
        $this->scheduleRepository = $scheduleRepository;
    }

    public function create(): ScheduleForm
    {
        return new ScheduleForm($this->disciplineRepository, $this->scheduleRepository);
    }
}