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

    private int $raceEventId;

    public function __construct(RaceResultRepository $raceResultRepository, RaceResultFormFactory $raceResultFormFactory)
    {
        $this->raceResultRepository = $raceResultRepository;
        $this->raceResultFormFactory = $raceResultFormFactory;
    }

    public function createComponentRaceResultForm(): RaceResultForm
    {
        $form = $this->raceResultFormFactory->create($this->raceEventId);

        $form->onFinish[] = function (RaceResultForm $raceResultForm) {
            $this->redirect('RaceResult:default');
        };

        return $form;
    }

    public function renderDefault()
    {
        $this->template->raceResults = $this->raceResultRepository->findAll();
    }

    public function actionEdit(int $raceEventId)
    {
        $this->raceEventId = $raceEventId;
    }

    public function renderEdit(int $id)
    {
        $raceResult = $this->raceResultRepository->getById($id);
        $raceEvent = $raceResult->getRaceEvent();
        $athlete = $raceResult->getAthlete();
        $racePosition = $raceResult->getRacePosition();

        $this['raceResultForm']['form']['id']->setDefaultValue($raceResult->getId());
        $this['raceResultForm']['form']['race_event_id']->setDefaultValue($raceEvent->getId());
        $this['raceResultForm']['form']['athlete_id']->setDefaultValue($athlete->getId());
        $this['raceResultForm']['form']['race_position_id']->setDefaultValue($racePosition->getId());
    }

    public function actionCreate(int $raceEventId)
    {
        $this->raceEventId = $raceEventId;
    }

    public function renderCreate(int $raceEventId)
    {
        $this['raceResultForm']['form']['race_event_id']->setDefaultValue($raceEventId);
    }

}