<?php
declare(strict_types=1);

namespace App\AdminModule\Presenters;

use App\AdminModule\Components\Forms\RacePosition\RacePositionForm;
use App\AdminModule\Components\Forms\RacePosition\RacePositionFormFactory;
use App\Model\Repositories\RacePositionRepository;
use Nette\Application\UI\Presenter;

class RacePositionPresenter extends Presenter
{
    private RacePositionRepository $racePositionRepository;

    private RacePositionFormFactory $racePositionFormFactory;

    public function __construct(
        RacePositionRepository $racePositionRepository,
        RacePositionFormFactory $racePositionFormFactory
    )
    {
        $this->racePositionRepository = $racePositionRepository;
        $this->racePositionFormFactory = $racePositionFormFactory;
    }

    public function createComponentRacePositionForm(): RacePositionForm
    {
        $form = $this->racePositionFormFactory->create();

        $form->onFinish[] = function (RacePositionForm $racePositionForm) use ($form) {
            $this->redirect('Sport:scoring' , ['sportId' => $form->getSportId()]);
        };

        $form->onDelete[] = function (RacePositionForm $racePositionForm) use ($form) {
            $this->redirect('Sport:scoring', ['sportId' => $form->getSportId()]);
        };

        return $form;
    }

    public function renderEdit(int $id)
    {
        $racePosition = $this->racePositionRepository->getById($id);
        $sport = $racePosition->getSport();

        $this['racePositionForm']['form']['id']->setDefaultValue($racePosition->getId());
        $this['racePositionForm']['form']['sport_id']->setDefaultValue($sport->getId());
        $this['racePositionForm']['form']['position']->setDefaultValue($racePosition->getPosition());
        $this['racePositionForm']['form']['point']->setDefaultValue($racePosition->getPoint());
    }

    public function renderCreate(int $sportId)
    {
        $this['racePositionForm']['form']['sport_id']->setDefaultValue($sportId);
    }

}