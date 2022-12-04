<?php
declare(strict_types=1);

namespace App\AdminModule\Components\Forms\Schedule;

use App\Model\Repositories\DisciplineGenderRepository;
use App\Model\Repositories\ScheduleRepository;
use App\Model\Repositories\SportRepository;

class ScheduleFormFactory
{
    private SportRepository $sportRepository;

    private DisciplineGenderRepository $disciplineGenderRepository;

    private ScheduleRepository $scheduleRepository;

    public function __construct(
        SportRepository $sportRepository,
        DisciplineGenderRepository $disciplineGenderRepository,
        ScheduleRepository $scheduleRepository
    )
    {
        $this->sportRepository = $sportRepository;
        $this->disciplineGenderRepository = $disciplineGenderRepository;
        $this->scheduleRepository = $scheduleRepository;
    }

    public function create(int $sportId): ScheduleForm
    {
        $form = new ScheduleForm($this->sportRepository, $this->disciplineGenderRepository, $this->scheduleRepository);

        $form->setSportId($sportId);

        return $form;
    }
}