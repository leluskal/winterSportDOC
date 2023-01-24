<?php
declare(strict_types=1);

namespace App\AdminModule\Presenters;

use App\AdminModule\Components\Forms\Athlete\AthleteForm;
use App\AdminModule\Components\Forms\Athlete\AthleteFormFactory;
use App\Model\Repositories\AthleteRepository;
use App\Model\Repositories\GenderRepository;
use App\Model\Repositories\SportRepository;
use Nette\Application\UI\Presenter;

class AthletePresenter extends Presenter
{
    private AthleteRepository $athleteRepository;

    private AthleteFormFactory $athleteFormFactory;

    private SportRepository $sportRepository;

    private GenderRepository $genderRepository;

    public function __construct(
        AthleteRepository $athleteRepository,
        AthleteFormFactory $athleteFormFactory,
        SportRepository $sportRepository
    )
    {
        $this->athleteRepository = $athleteRepository;
        $this->athleteFormFactory = $athleteFormFactory;
        $this->sportRepository = $sportRepository;
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
        $this->template->sports = $this->sportRepository->findAll();
//        $this->template->genders = $this->genderRepository->findAll();
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

    public function renderList(int $sportId)
    {
        $this->template->sport = $this->sportRepository->getById($sportId);
        $this->template->athletes = $this->athleteRepository->findAllBySportId($sportId);
    }
}