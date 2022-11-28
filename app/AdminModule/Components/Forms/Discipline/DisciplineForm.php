<?php
declare(strict_types=1);

namespace App\AdminModule\Components\Forms\Discipline;

use App\Model\Entities\Discipline\Discipline;
use App\Model\Repositories\DisciplineRepository;
use App\Model\Repositories\GenderRepository;
use App\Model\Repositories\SportRepository;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\SmartObject;
use Nette\Utils\ArrayHash;

class DisciplineForm extends Control
{
    use SmartObject;

    public array $onFinish;

    public array $onDelete;

    private int $sportId;

    private SportRepository $sportRepository;

    private GenderRepository $genderRepository;

    private DisciplineRepository $disciplineRepository;

    public function __construct(
        SportRepository $sportRepository,
        GenderRepository $genderRepository,
        DisciplineRepository $disciplineRepository
    )
    {
        $this->sportRepository = $sportRepository;
        $this->genderRepository = $genderRepository;
        $this->disciplineRepository = $disciplineRepository;
    }

    public function createComponentForm(): Form
    {
        $form = new Form();

        $form->addHidden('id');

        $form->addSelect('sport_id', 'Sport', $this->sportRepository->findAllForSelectBox())
             ->setPrompt('--Choose sport--')
             ->setRequired('The sport is required');

        $form->addSelect('gender_id', 'Gender', $this->genderRepository->findAllForSelectBox())
             ->setPrompt('--Choose gender--')
             ->setRequired('The gender is required');

        $form->addText('name', 'Discipline')
             ->setRequired('The name is required');

        $form->addCheckbox('world_cup_points', 'World Cup Points');

        $form->addSubmit('save', 'Save');

        $form->addSubmit('delete', 'Delete')
             ->setValidationScope([$form['id']]);

        $form->onSuccess[] = [$this, 'formSuccess'];

        return $form;
    }

    public function formSuccess(Form $form, ArrayHash $values)
    {
        if ($form['delete']->isSubmittedBy()) {
            $discipline = $this->disciplineRepository->getById((int) $values->id);
            $this->disciplineRepository->delete($discipline);
            $this->getPresenter()->flashMessage('The discipline record is deleted', 'info');
            $this->onDelete($this);
        }

        $sport = $this->sportRepository->getById((int) $values->sport_id);
        $gender = $this->genderRepository->getById((int) $values->gender_id);

        if ($values->id === '') {
            $discipline = new Discipline(
                $sport,
                $gender,
                $values->name,
                $values->world_cup_points
            );

            $this->disciplineRepository->save($discipline);
            $this->getPresenter()->flashMessage('The new discipline record is saved', 'success');
        }

        if ($values->id !== '') {
            $discipline = $this->disciplineRepository->getById((int)$values->id);

            $discipline->setSport($sport);
            $discipline->setGender($gender);
            $discipline->setName($values->name);
            $discipline->setWorldCupPoints($values->world_cup_points);

            $this->disciplineRepository->save($discipline);
            $this->getPresenter()->flashMessage('The discipline record is updated', 'info');
        }

        $this->sportId = $values->sport_id;

        $this->onFinish($this);
    }

    public function render()
    {
        $template = $this->getTemplate();
        $template->setFile(__DIR__ .'/disciplineForm.latte');
        $template->render();
    }

    public function getSportId(): int
    {
        return $this->sportId;
    }
}