<?php
declare(strict_types=1);

namespace App\FrontModule\Presenters;

use App\Model\Repositories\ScheduleRepository;
use App\Presenters\BasePresenter;
use Nette\Application\UI\Presenter;

class ProgramPresenter extends BasePresenter
{
    private ScheduleRepository $scheduleRepository;

    public function __construct(ScheduleRepository $scheduleRepository)
    {
        $this->scheduleRepository = $scheduleRepository;
    }

    public function renderDefault()
    {
        $this->template->schedulesGroupedByDate = $this->scheduleRepository->findAllGroupedByDate((int) $this->year);

        $this->template->year = $this->year;
    }
}