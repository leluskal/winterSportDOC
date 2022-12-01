<?php
declare(strict_types=1);

namespace App\AdminModule\Components\Forms\DisciplineGender;

use App\Model\Entities\DisciplineGender\DisciplineGender;
use App\Model\Repositories\DisciplineGenderRepository;
use App\Model\Repositories\DisciplineRepository;
use App\Model\Repositories\GenderRepository;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\SmartObject;
use Nette\Utils\ArrayHash;

class DisciplineGenderForm extends Control
{
    use SmartObject;

    public array $onFinish;

    private DisciplineRepository $disciplineRepository;

    private GenderRepository $genderRepository;

    private DisciplineGenderRepository $disciplineGenderRepository;

    public function __construct(
        DisciplineRepository $disciplineRepository,
        GenderRepository $genderRepository,
        DisciplineGenderRepository $disciplineGenderRepository
    )
    {
        $this->disciplineRepository = $disciplineRepository;
        $this->genderRepository = $genderRepository;
        $this->disciplineGenderRepository = $disciplineGenderRepository;
    }

    public function createComponentForm(): Form
    {
        $form = new Form();

        $form->addHidden('id');

        $form->addSelect('discipline_id', 'Discipline', $this->disciplineRepository->findAllForSelectBox())
             ->setPrompt('--Choose discipline--')
             ->setRequired('The discipline is required');

        $form->addSelect('gender_id', 'Gender', $this->genderRepository->findAllForSelectBox())
             ->setPrompt('--Choose gender--')
             ->setRequired('The gender is required');

        $form->addSubmit('save', 'Save');

        $form->onSuccess[] = [$this, 'formSuccess'];

        return $form;
    }

    public function formSuccess(Form $form, ArrayHash $values)
    {
        $discipline = $this->disciplineRepository->getById((int) $values->discipline_id);
        $gender = $this->genderRepository->getById((int) $values->gender_id);

        if ($values->id === '') {
            $disciplineGender = new DisciplineGender(
                $discipline,
                $gender
            );

            $this->disciplineGenderRepository->save($disciplineGender);
            $this->getPresenter()->flashMessage('The new record is saved', 'success');
        }

        if ($values->id !== '') {
            $disciplineGender = $this->disciplineGenderRepository->getById((int) $values->id);

            $disciplineGender->setDiscipline($discipline);
            $disciplineGender->setGender($gender);

            $this->disciplineGenderRepository->save($disciplineGender);
            $this->getPresenter()->flashMessage('The record is updated', 'info');
        }

        $this->onFinish($this);
    }

    public function render()
    {
        $template = $this->getTemplate();
        $template->setFile(__DIR__ .'/disciplineGenderForm.latte');
        $template->render();
    }
}