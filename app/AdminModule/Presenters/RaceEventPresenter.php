<?php
declare(strict_types=1);

namespace App\AdminModule\Presenters;

use App\AdminModule\Components\Forms\RaceEvent\RaceEventForm;
use App\AdminModule\Components\Forms\RaceEvent\RaceEventFormFactory;
use App\Model\Repositories\RaceEventRepository;
use Nette\Application\UI\Presenter;

class RaceEventPresenter extends Presenter
{
    private RaceEventRepository $raceEventRepository;

    private RaceEventFormFactory $raceEventFormFactory;

    public function __construct(RaceEventRepository $raceEventRepository, RaceEventFormFactory $raceEventFormFactory)
    {
        $this->raceEventRepository = $raceEventRepository;
        $this->raceEventFormFactory = $raceEventFormFactory;
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

}