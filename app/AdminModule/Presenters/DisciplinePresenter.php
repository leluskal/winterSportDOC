<?php
declare(strict_types=1);

namespace App\AdminModule\Presenters;

use App\AdminModule\Components\Forms\Discipline\DisciplineForm;
use App\AdminModule\Components\Forms\Discipline\DisciplineFormFactory;
use App\Model\Repositories\DisciplineRepository;
use App\Model\Repositories\RaceEventRepository;
use App\Model\Repositories\RaceResultRepository;
use Nette\Application\UI\Presenter;

class DisciplinePresenter extends Presenter
{
    private DisciplineRepository $disciplineRepository;

    private DisciplineFormFactory $disciplineFormFactory;

    private RaceEventRepository $raceEventRepository;

    public function __construct(
        DisciplineRepository $disciplineRepository,
        DisciplineFormFactory $disciplineFormFactory,
        RaceEventRepository $raceEventRepository
    )
    {
        $this->disciplineRepository = $disciplineRepository;
        $this->disciplineFormFactory = $disciplineFormFactory;
        $this->raceEventRepository = $raceEventRepository;
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
        $gender = $discipline->getGender();

        $this['disciplineForm']['form']['id']->setDefaultValue($discipline->getId());
        $this['disciplineForm']['form']['sport_id']->setDefaultValue($sport->getId());
        $this['disciplineForm']['form']['gender_id']->setDefaultValue($gender->getId());
        $this['disciplineForm']['form']['name']->setDefaultValue($discipline->getName());
    }

    public function renderCreate(int $sportId)
    {
        $this['disciplineForm']['form']['sport_id']->setDefaultValue($sportId);
    }

    public function renderEvent(int $disciplineId)
    {
        $this->template->discipline = $this->disciplineRepository->getById($disciplineId);
        $this->template->raceEvents = $this->raceEventRepository->findAllByDisciplineId($disciplineId);
    }
}