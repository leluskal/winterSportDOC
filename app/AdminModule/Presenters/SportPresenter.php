<?php
declare(strict_types=1);

namespace App\AdminModule\Presenters;

use App\AdminModule\Components\Forms\Sport\SportForm;
use App\AdminModule\Components\Forms\Sport\SportFormFactory;
use App\Model\Repositories\RacePositionRepository;
use App\Model\Repositories\SportRepository;
use Nette\Application\UI\Presenter;

class SportPresenter extends Presenter
{
    private SportRepository $sportRepository;

    private SportFormFactory $sportFormFactory;

    private RacePositionRepository $racePositionRepository;

    public function __construct(
        SportRepository $sportRepository,
        SportFormFactory $sportFormFactory,
        RacePositionRepository $racePositionRepository
    )
    {
        $this->sportRepository = $sportRepository;
        $this->sportFormFactory = $sportFormFactory;
        $this->racePositionRepository = $racePositionRepository;
    }

    public function createComponentSportForm(): SportForm
    {
        $form = $this->sportFormFactory->create();

        $form->onFinish[] = function (SportForm $sportForm) {
            $this->redirect('Sport:default');
        };

        $form->onDelete[] = function (SportForm $sportForm) {
          $this->redirect('Sport:default');
        };

        return $form;
    }

    public function renderDefault()
    {
        $this->template->sports = $this->sportRepository->findAll();
    }

    public function renderEdit(int $id)
    {
        $sport = $this->sportRepository->getById($id);

        $this['sportForm']['form']['id']->setDefaultValue($sport->getId());
        $this['sportForm']['form']['name']->setDefaultValue($sport->getName());
    }

    public function renderCreate()
    {

    }

    public function renderScoring(int $sportId)
    {
        $this->template->sport = $this->sportRepository->getById($sportId);
        $this->template->racePositions = $this->racePositionRepository->findAllBySportId($sportId);
    }

    public function handleDeleteRacePosition(int $racePositionId)
    {
        $racePosition = $this->racePositionRepository->getById($racePositionId);

        $this->racePositionRepository->delete($racePosition);
        $this->flashMessage('The record is deleted', 'info');
        $this->redirect('Sport:scoring', $racePosition->getSport()->getId());
    }
}