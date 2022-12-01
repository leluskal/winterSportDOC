<?php
declare(strict_types=1);

namespace App\AdminModule\Presenters;

use App\AdminModule\Components\Forms\RacePoint\RacePointForm;
use App\AdminModule\Components\Forms\RacePoint\RacePointFormFactory;
use App\Model\Repositories\RacePointRepository;
use Nette\Application\UI\Presenter;

class RacePointPresenter extends Presenter
{
    private RacePointRepository $racePointRepository;

    private RacePointFormFactory $racePointFormFactory;

    public function __construct(
        RacePointRepository     $racePositionRepository,
        RacePointFormFactory $racePositionFormFactory
    )
    {
        $this->racePointRepository = $racePositionRepository;
        $this->racePointFormFactory = $racePositionFormFactory;
    }

    public function createComponentRacePointForm(): RacePointForm
    {
        $form = $this->racePointFormFactory->create();

        $form->onFinish[] = function (RacePointForm $racePointForm) use ($form) {
            $this->redirect('Discipline:scoring' , ['disciplineId' => $form->getDisciplineId()]);
        };

        return $form;
    }

    public function renderEdit(int $id)
    {
        $racePoint = $this->racePointRepository->getById($id);
        $discipline = $racePoint->getDiscipline();

        $this['racePointForm']['form']['id']->setDefaultValue($racePoint->getId());
        $this['racePointForm']['form']['discipline_id']->setDefaultValue($discipline->getId());
        $this['racePointForm']['form']['position']->setDefaultValue($racePoint->getPosition());
        $this['racePointForm']['form']['points']->setDefaultValue($racePoint->getPoints());
    }

    public function renderCreate(int $disciplineId)
    {
        $this['racePointForm']['form']['discipline_id']->setDefaultValue($disciplineId);
    }

}