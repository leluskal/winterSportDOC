<?php
declare(strict_types=1);

namespace App\AdminModule\Presenters;

use App\AdminModule\Components\Forms\Schedule\ScheduleForm;
use App\AdminModule\Components\Forms\Schedule\ScheduleFormFactory;
use App\Model\Repositories\ScheduleRepository;
use Nette\Application\UI\Presenter;

class SchedulePresenter extends Presenter
{
    private ScheduleRepository $scheduleRepository;

    private ScheduleFormFactory $scheduleFormFactory;

    public function __construct(ScheduleRepository $scheduleRepository, ScheduleFormFactory $scheduleFormFactory)
    {
        $this->scheduleRepository = $scheduleRepository;
        $this->scheduleFormFactory = $scheduleFormFactory;
    }

    public function createComponentScheduleForm(): ScheduleForm
    {
        $form = $this->scheduleFormFactory->create();

        $form->onFinish[] =function (ScheduleForm $scheduleForm) use ($form) {
            $this->redirect('Sport:schedule', ['sportId' => $form->getSportId()]);
        };

        return $form;
    }

    public function renderEdit(int $id)
    {
        $schedule = $this->scheduleRepository->getById($id);
        $sport = $schedule->getSport();
        $discipline = $schedule->getDiscipline();

        $this['scheduleForm']['form']['id']->setDefaultValue($schedule->getId());
        $this['scheduleForm']['form']['sport_id']->setDefaultValue($sport->getId());
        $this['scheduleForm']['form']['discipline_id']->setDefaultValue($discipline->getId());
        $this['scheduleForm']['form']['event_date']->setDefaultValue($schedule->getEventDate()->format('Y-m-d\TH:i'));
        $this['scheduleForm']['form']['event_place']->setDefaultValue($schedule->getEventPlace());
        $this['scheduleForm']['form']['seen']->setDefaultValue($schedule->isSeen());
    }

    public function renderCreate(int $sportId)
    {
        $this['scheduleForm']['form']['sport_id']->setDefaultValue($sportId);

    }
}