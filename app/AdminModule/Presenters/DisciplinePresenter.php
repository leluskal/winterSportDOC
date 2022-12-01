<?php
declare(strict_types=1);

namespace App\AdminModule\Presenters;

use App\AdminModule\Components\Forms\Discipline\DisciplineForm;
use App\AdminModule\Components\Forms\Discipline\DisciplineFormFactory;
use App\Model\Repositories\DisciplineRepository;
use App\Model\Repositories\RacePositionRepository;
use Nette\Application\UI\Presenter;

class DisciplinePresenter extends Presenter
{
    private DisciplineRepository $disciplineRepository;

    private DisciplineFormFactory $disciplineFormFactory;

    private RacePositionRepository $racePositionRepository;

    public function __construct(
        DisciplineRepository $disciplineRepository,
        DisciplineFormFactory $disciplineFormFactory,
        RacePositionRepository $racePositionRepository
    )
    {
        $this->disciplineRepository = $disciplineRepository;
        $this->disciplineFormFactory = $disciplineFormFactory;
        $this->racePositionRepository = $racePositionRepository;
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
        $this->template->racePositions = $this->racePositionRepository->findAllByDisciplineId($disciplineId);
    }

}