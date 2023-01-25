<?php
declare(strict_types=1);

namespace App\AdminModule\Components\Forms\Athlete;

use App\Model\Entities\Athlete\Athlete;
use App\Model\Repositories\AthleteRepository;
use App\Model\Repositories\GenderRepository;
use App\Model\Repositories\SportRepository;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\SmartObject;
use Nette\Utils\ArrayHash;

class AthleteForm extends Control
{
    use SmartObject;

    public array $onFinish;

    private int $sportId;

    private int $genderId;

    private GenderRepository $genderRepository;

    private SportRepository $sportRepository;

    private AthleteRepository $athleteRepository;

    public function __construct(
        GenderRepository $genderRepository,
        SportRepository $sportRepository,
        AthleteRepository $athleteRepository
    )
    {
        $this->genderRepository = $genderRepository;
        $this->sportRepository = $sportRepository;
        $this->athleteRepository = $athleteRepository;
    }

    public function createComponentForm(): Form
    {
        $form = new Form();

        $form->addHidden('id');

        $form->addText('firstname', 'Firstname')
             ->setRequired('The firstname is required');

        $form->addText('lastname', 'Lastname')
             ->setRequired('The lastname is required');

        $form->addSelect('gender_id', 'Gender', $this->genderRepository->findAllForSelectBox())
             ->setPrompt('--Choose gender--')
             ->setRequired('The gender is required');

        $form->addText('country', 'Country')
             ->setRequired('The country is required');

        $form->addSelect('sport_id', 'Sport', $this->sportRepository->findAllForSelectBox())
             ->setPrompt('--Choose sport--')
             ->setRequired('The sport is required');

        $form->addSubmit('save', 'Save');

        $form->onSuccess[] = [$this, 'formSuccess'];

        return $form;
    }

    public function formSuccess(Form $form, ArrayHash $values)
    {
        $gender = $this->genderRepository->getById((int) $values->gender_id);
        $sport = $this->sportRepository->getById((int) $values->sport_id);

        if ($values->id === '') {
            $athlete = new Athlete(
                $values->firstname,
                $values->lastname,
                $gender,
                $values->country,
                $sport
            );

            $this->athleteRepository->save($athlete);
            $this->getPresenter()->flashMessage('The new athlete record is saved', 'success');
        }

        if ($values->id !== '') {
            $athlete = $this->athleteRepository->getById((int) $values->id);

            $athlete->setFirstname($values->firstname);
            $athlete->setLastname($values->lastname);
            $athlete->setGender($gender);
            $athlete->setCountry($values->country);
            $athlete->setSport($sport);

            $this->athleteRepository->save($athlete);
            $this->getPresenter()->flashMessage('The athlete record is updated', 'info');
        }

        $this->sportId = $values->sport_id;
        $this->genderId = $values->gender_id;

        $this->onFinish($this);
    }

    public function render()
    {
        $template = $this->getTemplate();
        $template->setFile(__DIR__ .'/athleteForm.latte');
        $template->render();
    }

    public function getSportId(): int
    {
        return $this->sportId;
    }

    public function getGenderId(): int
    {
        return $this->genderId;
    }
}