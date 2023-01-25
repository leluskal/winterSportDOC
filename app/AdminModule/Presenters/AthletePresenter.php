<?php
declare(strict_types=1);

namespace App\AdminModule\Presenters;

use App\AdminModule\Components\Forms\Athlete\AthleteForm;
use App\AdminModule\Components\Forms\Athlete\AthleteFormFactory;
use App\Model\Repositories\AthleteRepository;
use App\Model\Repositories\GenderRepository;
use App\Model\Repositories\SportRepository;
use App\Presenters\BasePresenter;
use Nette\Application\UI\Presenter;

class AthletePresenter extends BasePresenter
{
    private AthleteRepository $athleteRepository;

    private AthleteFormFactory $athleteFormFactory;

    private SportRepository $sportRepository;

    private GenderRepository $genderRepository;

    public function __construct(
        AthleteRepository $athleteRepository,
        AthleteFormFactory $athleteFormFactory,
        SportRepository $sportRepository,
        GenderRepository $genderRepository
    )
    {
        $this->athleteRepository = $athleteRepository;
        $this->athleteFormFactory = $athleteFormFactory;
        $this->sportRepository = $sportRepository;
        $this->genderRepository = $genderRepository;
    }

    public function createComponentAthleteForm(): AthleteForm
    {
        $form = $this->athleteFormFactory->create();

        $form->onFinish[] = function (AthleteForm $athleteForm) use ($form) {
            $this->redirect('Athlete:list', ['sportId' => $form->getSportId(), 'genderId' => $form->getGenderId()]);
        };

        return $form;
    }

    public function renderDefault()
    {
        $this->template->sports = $this->sportRepository->findAll();
        $this->template->genders = $this->genderRepository->findAll();
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

    public function renderCreate(int $genderId, int $sportId)
    {
        $this['athleteForm']['form']['gender_id']->setDefaultValue($genderId);
        $this['athleteForm']['form']['sport_id']->setDefaultValue($sportId);
    }

    public function renderList(int $sportId, int $genderId)
    {
        $this->template->sport = $this->sportRepository->getById($sportId);
        $this->template->gender = $this->genderRepository->getById($genderId);
        $this->template->athletes = $this->athleteRepository->findAllBySportIdAndGenderId($sportId, $genderId);
    }

    public function handleDeleteAthlete(int $athleteId)
    {
        $athlete = $this->athleteRepository->getById($athleteId);

        $this->athleteRepository->delete($athlete);
        $this->flashMessage('The athlete record is deleted', 'info');
        $this->redirect('Athlete:list', $athlete->getSport()->getId(),$athlete->getGender()->getId());
    }
}