<?php
declare(strict_types=1);

namespace App\AdminModule\Components\Forms\RacePosition;

use App\Model\Entities\RacePosition\RacePosition;
use App\Model\Repositories\RacePositionRepository;
use App\Model\Repositories\SportRepository;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\SmartObject;
use Nette\Utils\ArrayHash;

class RacePositionForm extends Control
{
    use SmartObject;

    public array $onFinish;

    public array $onDelete;

    private int $sportId;

    private SportRepository $sportRepository;

    private RacePositionRepository $racePositionRepository;

    public function __construct(SportRepository $sportRepository, RacePositionRepository $racePositionRepository)
    {
        $this->sportRepository = $sportRepository;
        $this->racePositionRepository = $racePositionRepository;
    }

    public function createComponentForm(): Form
    {
        $form = new Form();

        $form->addHidden('id');

        $form->addSelect('sport_id', 'Sport', $this->sportRepository->findAllForSelectBox())
             ->setRequired('The sport is required');

        $form->addInteger('position', 'Position')
             ->setRequired('The position is required');

        $form->addInteger('point', 'Points')
             ->setRequired('The point is required');

        $form->addSubmit('save', 'Save');

        $form->onSuccess[] = [$this, 'formSuccess'];

        return $form;
    }

    public function formSuccess(Form $form, ArrayHash $values)
    {
        $sport = $this->sportRepository->getById((int) $values->sport_id);

        if ($values->id === '') {
            $racePosition = new RacePosition(
                $sport,
                $values->position,
                $values->point
            );

            $this->racePositionRepository->save($racePosition);
            $this->getPresenter()->flashMessage('The new record is saved', 'success');
        }

        if ($values->id !== '') {
            $racePosition = $this->racePositionRepository->getById((int) $values->id);

            $racePosition->setSport($sport);
            $racePosition->setPosition($values->position);
            $racePosition->setPoint($values->point);

            $this->getPresenter()->flashMessage('The record is updated', 'info');
        }

        $this->sportId = $values->sport_id;

        $this->onFinish($this);
    }

    public function render()
    {
        $template = $this->getTemplate();
        $template->setFile(__DIR__ .'/racePositionForm.latte');
        $template->render();
    }

    public function getSportId(): int
    {
        return $this->sportId;
    }
}