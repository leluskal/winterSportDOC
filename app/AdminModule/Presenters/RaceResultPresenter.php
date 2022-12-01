<?php
declare(strict_types=1);

namespace App\AdminModule\Presenters;

use App\AdminModule\Components\Forms\RaceResult\RaceResultForm;
use App\AdminModule\Components\Forms\RaceResult\RaceResultFormFactory;
use App\Model\Repositories\RaceResultRepository;
use Nette\Application\UI\Presenter;

class RaceResultPresenter extends Presenter
{
    private RaceResultRepository $raceResultRepository;

    private RaceResultFormFactory $raceResultFormFactory;

    private int $scheduleId;

    public function __construct(RaceResultRepository $raceResultRepository, RaceResultFormFactory $raceResultFormFactory)
    {
        $this->raceResultRepository = $raceResultRepository;
        $this->raceResultFormFactory = $raceResultFormFactory;
    }

    public function createComponentRaceResultForm(): RaceResultForm
    {
        $form = $this->raceResultFormFactory->create($this->scheduleId);

        $form->onFinish[] = function (RaceResultForm $raceResultForm) use ($form) {
            $this->redirect('Schedule:result', ['scheduleId' => $form->getSchedule()->getId()]);
        };

        return $form;
    }

    public function actionEdit(int $scheduleId)
    {
        $this->scheduleId = $scheduleId;
    }

    public function renderEdit(int $id)
    {
        $raceResult = $this->raceResultRepository->getById($id);
        $schedule = $raceResult->getSchedule();
        $athlete = $raceResult->getAthlete();
        $racePoint = $raceResult->getRacePoint();

        $this['raceResultForm']['form']['id']->setDefaultValue($raceResult->getId());
        $this['raceResultForm']['form']['schedule_id']->setDefaultValue($schedule->getId());
        $this['raceResultForm']['form']['athlete_id']->setDefaultValue($athlete->getId());
        $this['raceResultForm']['form']['race_point_id']->setDefaultValue($racePoint->getId());
    }

    public function actionCreate(int $scheduleId)
    {
        $this->scheduleId = $scheduleId;
    }

    public function renderCreate(int $scheduleId)
    {
        $this['raceResultForm']['form']['schedule_id']->setDefaultValue($scheduleId);
    }

}