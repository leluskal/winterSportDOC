<?php
declare(strict_types=1);

namespace App\AdminModule\Presenters;

use App\AdminModule\Components\Forms\Sport\SportForm;
use App\AdminModule\Components\Forms\Sport\SportFormFactory;
use App\Model\Repositories\SportRepository;
use Nette\Application\UI\Presenter;

class SportPresenter extends Presenter
{
    private SportRepository $sportRepository;

    private SportFormFactory $sportFormFactory;

    public function __construct(SportRepository $sportRepository, SportFormFactory $sportFormFactory)
    {
        $this->sportRepository = $sportRepository;
        $this->sportFormFactory = $sportFormFactory;
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
}