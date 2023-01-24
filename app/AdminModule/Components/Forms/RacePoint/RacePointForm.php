<?php
declare(strict_types=1);

namespace App\AdminModule\Components\Forms\RacePoint;

use App\Model\Entities\RacePoint\RacePoint;
use App\Model\Repositories\DisciplineRepository;
use App\Model\Repositories\RacePointRepository;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\SmartObject;
use Nette\Utils\ArrayHash;

class RacePointForm extends Control
{
    use SmartObject;

    public array $onFinish;

    private int $disciplineId;

    private DisciplineRepository $disciplineRepository;

    private RacePointRepository $racePointRepository;

    public function __construct(
        DisciplineRepository $disciplineRepository,
        RacePointRepository $racePointRepository
    )
    {
        $this->disciplineRepository = $disciplineRepository;
        $this->racePointRepository = $racePointRepository;
    }

    public function createComponentForm(): Form
    {
        $form = new Form();

        $form->addHidden('id');

        $form->addSelect('discipline_id', 'Discipline', $this->disciplineRepository->findAllForSelectBox())
             ->setPrompt('--Choose discipline--')
             ->setRequired('The discipline is required');

        $form->addInteger('position', 'Position')
             ->setRequired('The position is required');

        $form->addInteger('points', 'Points')
             ->setRequired('The point is required');

        $form->addSubmit('save', 'Save');

        $form->onSuccess[] = [$this, 'formSuccess'];

        return $form;
    }

    public function formSuccess(Form $form, ArrayHash $values)
    {
        $discipline = $this->disciplineRepository->getById((int) $values->discipline_id);

        if ($values->id === '') {
            $racePoint = new RacePoint(
                $discipline,
                $values->position,
                $values->points
            );

            $this->racePointRepository->save($racePoint);
            $this->getPresenter()->flashMessage('The new record is saved', 'success');
        }

        if ($values->id !== '') {

            $racePoint = $this->racePointRepository->getById((int) $values->id);

            $racePoint->setDiscipline($discipline);
            $racePoint->setPosition($values->position);
            $racePoint->setPoints($values->points);

            $this->racePointRepository->save($racePoint);

            $this->getPresenter()->flashMessage('The record is updated', 'info');
        }

        $this->disciplineId = $values->discipline_id;

        $this->onFinish($this);
    }

    public function render()
    {
        $template = $this->getTemplate();
        $template->setFile(__DIR__ .'/racePointForm.latte');
        $template->render();
    }

    public function getDisciplineId(): int
    {
        return $this->disciplineId;
    }
}