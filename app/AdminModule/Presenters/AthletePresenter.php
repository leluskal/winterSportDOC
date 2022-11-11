<?php
declare(strict_types=1);

namespace App\AdminModule\Presenters;

use App\AdminModule\Components\Forms\Athlete\AthleteForm;
use App\AdminModule\Components\Forms\Athlete\AthleteFormFactory;
use App\Model\Repositories\AthleteRepository;
use Nette\Application\UI\Presenter;

class AthletePresenter extends Presenter
{
    private AthleteRepository $athleteRepository;

    private AthleteFormFactory $athleteFormFactory;

    public function __construct(AthleteRepository $athleteRepository, AthleteFormFactory $athleteFormFactory)
    {
        $this->athleteRepository = $athleteRepository;
        $this->athleteFormFactory = $athleteFormFactory;
    }

    public function createComponentAthleteForm(): AthleteForm
    {
        $form = $this->athleteFormFactory->create();

        $form->onFinish[] = function (AthleteForm $athleteForm) {
            $this->redirect('Athlete:default');
        };

        $form->onDelete[] = function (AthleteForm $athleteForm) {
            $this->redirect('Athlete:default');
        };

        return $form;
    }

    public function renderDefault()
    {
        $this->template->athletes = $this->athleteRepository->findAll();
    }

    public function renderEdit(int $id)
    {
        $athlete = $this->athleteRepository->getById($id);
        $gender = $athlete->getGender();
        $sport = $athlete->getSport();

        $this['athleteForm']['form']['id']->setDefaultValue($athlete->getId());
        $this['athleteForm']['form']['firstname']->setDefaultValue($athlete->getFirstname());
        $this['athleteForm']['form']['lastname']->setDefaultValue($athlete->getLastname());
        $this['athleteForm']['form']['gender_id']->setDefaultValue($gender->getId());
        $this['athleteForm']['form']['country']->setDefaultValue($athlete->getCountry());
        $this['athleteForm']['form']['sport_id']->setDefaultValue($sport->getId());
    }

    public function renderCreate()
    {

    }
}