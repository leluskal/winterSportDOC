<?php
declare(strict_types=1);

namespace App\AdminModule\Presenters;

use App\AdminModule\Components\Forms\Gender\GenderForm;
use App\AdminModule\Components\Forms\Gender\GenderFormFactory;
use App\Model\Repositories\GenderRepository;
use Nette\Application\UI\Presenter;

class GenderPresenter extends Presenter
{
    private GenderRepository $genderRepository;

    private GenderFormFactory $genderFormFactory;

    public function __construct(GenderRepository $genderRepository, GenderFormFactory $genderFormFactory)
    {
        $this->genderRepository = $genderRepository;
        $this->genderFormFactory = $genderFormFactory;
    }

    public function createComponentGenderForm(): GenderForm
    {
        $form = $this->genderFormFactory->create();

        $form->onFinish[] = function (GenderForm $genderForm) {
            $this->redirect('Gender:default');
        };

        return $form;
    }

    public function renderDefault()
    {
        $this->template->genders = $this->genderRepository->findAll();
    }

    public function renderEdit(int $id)
    {
        $gender = $this->genderRepository->getById($id);

        $this['genderForm']['form']['id']->setDefaultValue($gender->getId());
        $this['genderForm']['form']['name']->setDefaultValue($gender->getName());
    }

    public function renderCreate()
    {

    }
}