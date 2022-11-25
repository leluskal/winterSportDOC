<?php
declare(strict_types=1);

namespace App\AdminModule\Presenters;

use App\AdminModule\Components\Forms\RaceEvent\RaceEventForm;
use App\AdminModule\Components\Forms\RaceEvent\RaceEventFormFactory;
use App\Model\Repositories\RaceEventRepository;
use App\Model\Repositories\RaceResultRepository;
use Nette\Application\UI\Presenter;

class RaceEventPresenter extends Presenter
{
    private RaceEventRepository $raceEventRepository;

    private RaceEventFormFactory $raceEventFormFactory;

    private RaceResultRepository $raceResultRepository;

    public function __construct(
        RaceEventRepository $raceEventRepository,
        RaceEventFormFactory $raceEventFormFactory,
        RaceResultRepository $raceResultRepository
    )
    {
        $this->raceEventRepository = $raceEventRepository;
        $this->raceEventFormFactory = $raceEventFormFactory;
        $this->raceResultRepository = $raceResultRepository;
    }

    public function createComponentRaceEventForm(): RaceEventForm
    {
        $form = $this->raceEventFormFactory->create();

        $form->onFinish[] = function (RaceEventForm $raceEventForm) use ($form) {
            $this->redirect('Discipline:event', ['disciplineId' => $form->getDisciplineId()]);
        };

        return $form;
    }

    public function renderEdit(int $id)
    {
        $raceEvent = $this->raceEventRepository->getById($id);
        $schedule = $raceEvent->getSchedule();

        $this['raceEventForm']['form']['id']->setDefaultValue($raceEvent->getId());
        $this['raceEventForm']['form']['schedule_id']->setDefaultValue($schedule->getId());
        $this['raceEventForm']['form']['venue']->setDefaultValue($raceEvent->getVenue());
    }

    public function renderCreate()
    {

    }

    public function renderResult(int $raceEventId)
    {
        $this->template->raceEvent = $this->raceEventRepository->getById($raceEventId);
        $this->template->raceResults = $this->raceResultRepository->findAllByRaceEventId($raceEventId);
    }

}