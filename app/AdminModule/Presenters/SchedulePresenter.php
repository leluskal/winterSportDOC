<?php
declare(strict_types=1);

namespace App\AdminModule\Presenters;

use App\AdminModule\Components\Forms\Schedule\ScheduleForm;
use App\AdminModule\Components\Forms\Schedule\ScheduleFormFactory;
use App\Model\Repositories\RaceResultRepository;
use App\Model\Repositories\ScheduleRepository;
use App\Presenters\BasePresenter;

class SchedulePresenter extends BasePresenter
{
    private ScheduleRepository $scheduleRepository;

    private ScheduleFormFactory $scheduleFormFactory;

    private RaceResultRepository $raceResultRepository;

    private int $sportId;

    public function __construct(
        ScheduleRepository $scheduleRepository,
        ScheduleFormFactory $scheduleFormFactory,
        RaceResultRepository $raceResultRepository
    )
    {
        $this->scheduleRepository = $scheduleRepository;
        $this->scheduleFormFactory = $scheduleFormFactory;
        $this->raceResultRepository = $raceResultRepository;
    }

    public function createComponentScheduleForm(): ScheduleForm
    {
        $form = $this->scheduleFormFactory->create($this->sportId);

        $form->onFinish[] =function (ScheduleForm $scheduleForm) use ($form) {
            $this->redirect('Sport:schedule', ['sportId' => $form->getSportId()]);
        };

        $form->onDelete[] = function (ScheduleForm $scheduleForm) use ($form) {
            $this->redirect('Sport:schedule', ['sportId' => $form->getSportId()]);
        };

        return $form;
    }

    public function renderEdit(int $id)
    {
        $schedule = $this->scheduleRepository->getById($id);
        $sport = $schedule->getSport();
        $disciplineGender = $schedule->getDisciplineGender();

        $this['scheduleForm']['form']['id']->setDefaultValue($schedule->getId());
        $this['scheduleForm']['form']['sport_id']->setDefaultValue($sport->getId());
        $this['scheduleForm']['form']['discipline_gender_id']->setDefaultValue($disciplineGender->getId());
        $this['scheduleForm']['form']['event_date']->setDefaultValue($schedule->getEventDate()->format('Y-m-d\TH:i'));
        $this['scheduleForm']['form']['event_place']->setDefaultValue($schedule->getEventPlace());
        $this['scheduleForm']['form']['year']->setDefaultValue($schedule->getYear());
    }

    public function renderCreate(int $sportId, int $year)
    {
        $this['scheduleForm']['form']['sport_id']->setDefaultValue($sportId);
        $this['scheduleForm']['form']['year']->setDefaultValue($year);
    }

    public function actionCreate(int $sportId)
    {
        $this->sportId = $sportId;
    }

    public function actionEdit(int $sportId)
    {
        $this->sportId = $sportId;
    }

    public function renderResult(int $scheduleId)
    {
        $this->template->schedule = $this->scheduleRepository->getById($scheduleId);
        $this->template->raceResults = $this->raceResultRepository->findAllByScheduleId($scheduleId);
    }

    public function handleDeleteRaceResult(int $raceResultId)
    {
        $raceResult = $this->raceResultRepository->getById($raceResultId);

        $this->raceResultRepository->delete($raceResult);
        $this->flashMessage('The race result record is deleted', 'info');
        $this->redirect('Schedule:result', $raceResult->getSchedule()->getId());
    }
}