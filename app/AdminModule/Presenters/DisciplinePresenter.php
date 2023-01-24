<?php
declare(strict_types=1);

namespace App\AdminModule\Presenters;

use App\AdminModule\Components\Forms\Discipline\DisciplineForm;
use App\AdminModule\Components\Forms\Discipline\DisciplineFormFactory;
use App\Model\Repositories\DisciplineRepository;
use App\Model\Repositories\RacePointRepository;
use Nette\Application\UI\Presenter;

class DisciplinePresenter extends Presenter
{
    private DisciplineRepository $disciplineRepository;

    private DisciplineFormFactory $disciplineFormFactory;

    private RacePointRepository $racePointRepository;

    public function __construct(
        DisciplineRepository $disciplineRepository,
        DisciplineFormFactory $disciplineFormFactory,
        RacePointRepository $racePointRepository
    )
    {
        $this->disciplineRepository = $disciplineRepository;
        $this->disciplineFormFactory = $disciplineFormFactory;
        $this->racePointRepository = $racePointRepository;
    }

    public function createComponentDisciplineForm(): DisciplineForm
    {
        $form = $this->disciplineFormFactory->create();

        $form->onFinish[] = function (DisciplineForm $disciplineForm) use ($form) {
            $this->redirect('Sport:discipline', ['sportId' => $form->getSportId()]);
        };

        $form->onDelete[] = function (DisciplineForm $disciplineForm) use ($form) {
            $this->redirect('Sport:discipline', ['sportId' => $form->getSportId()]);
        };

        return $form;
    }

    public function renderEdit(int $id)
    {
        $discipline = $this->disciplineRepository->getById($id);
        $sport = $discipline->getSport();

        $this['disciplineForm']['form']['id']->setDefaultValue($discipline->getId());
        $this['disciplineForm']['form']['sport_id']->setDefaultValue($sport->getId());
        $this['disciplineForm']['form']['name']->setDefaultValue($discipline->getName());
        $this['disciplineForm']['form']['world_cup_points']->setDefaultValue($discipline->isWorldCupPoints());
    }

    public function renderCreate(int $sportId)
    {
        $this['disciplineForm']['form']['sport_id']->setDefaultValue($sportId);
    }

    public function renderScoring(int $disciplineId)
    {
        $this->template->discipline = $this->disciplineRepository->getById($disciplineId);
        $this->template->racePoints = $this->racePointRepository->findAllByDisciplineId($disciplineId);
    }

    public function handleDeleteRacePoint(int $racePointId)
    {
        $racePoint = $this->racePointRepository->getById($racePointId);

        $this->racePointRepository->delete($racePoint);
        $this->flashMessage('The record is deleted', 'info');
        $this->redirect('Discipline:scoring', $racePoint->getDiscipline()->getId());
    }

}