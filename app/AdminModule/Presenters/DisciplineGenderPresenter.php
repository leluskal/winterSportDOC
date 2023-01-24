<?php
declare(strict_types=1);

namespace App\AdminModule\Presenters;

use App\AdminModule\Components\Forms\DisciplineGender\DisciplineGenderForm;
use App\AdminModule\Components\Forms\DisciplineGender\DisciplineGenderFormFactory;
use App\Model\Repositories\DisciplineGenderRepository;
use Nette\Application\UI\Presenter;

class DisciplineGenderPresenter extends Presenter
{
    private DisciplineGenderRepository $disciplineGenderRepository;

    private DisciplineGenderFormFactory $disciplineGenderFormFactory;

    public function __construct(
        DisciplineGenderRepository $disciplineGenderRepository,
        DisciplineGenderFormFactory $disciplineGenderFormFactory
    )
    {
        $this->disciplineGenderRepository = $disciplineGenderRepository;
        $this->disciplineGenderFormFactory = $disciplineGenderFormFactory;
    }

    public function createComponentDisciplineGenderForm(): DisciplineGenderForm
    {
        $form = $this->disciplineGenderFormFactory->create();

        $form->onFinish[] = function (DisciplineGenderForm $disciplineGenderForm)  {
            $this->redirect('DisciplineGender:default');
        };

        $form->onDelete[] = function (DisciplineGenderForm $disciplineGenderForm)  {
            $this->redirect('DisciplineGender:default');
        };

        return $form;
    }

    public function renderDefault()
    {
        $this->template->disciplineGenders = $this->disciplineGenderRepository->findAll();
    }

    public function renderEdit(int $id)
    {
        $disciplineGender = $this->disciplineGenderRepository->getById($id);
        $discipline = $disciplineGender->getDiscipline();
        $gender = $disciplineGender->getGender();

        $this['disciplineGenderForm']['form']['id']->setDefaultValue($disciplineGender->getId());
        $this['disciplineGenderForm']['form']['discipline_id']->setDefaultValue($discipline->getId());
        $this['disciplineGenderForm']['form']['gender_id']->setDefaultValue($gender->getId());
    }

    public function renderCreate()
    {

    }


}