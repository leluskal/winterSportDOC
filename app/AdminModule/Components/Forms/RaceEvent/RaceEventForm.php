<?php
declare(strict_types=1);

namespace App\AdminModule\Components\Forms\RaceEvent;

use App\Model\Entities\RaceEvent\RaceEvent;
use App\Model\Repositories\RaceEventRepository;
use App\Model\Repositories\ScheduleRepository;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\SmartObject;
use Nette\Utils\ArrayHash;

class RaceEventForm extends Control
{
    use SmartObject;

    public array $onFinish;

    private int $disciplineId;

    private ScheduleRepository $scheduleRepository;

    private RaceEventRepository $raceEventRepository;

    public function __construct(ScheduleRepository $scheduleRepository, RaceEventRepository $raceEventRepository)
    {
        $this->scheduleRepository = $scheduleRepository;
        $this->raceEventRepository = $raceEventRepository;
    }

    public function createComponentForm(): Form
    {
        $form = new Form();

        $form->addHidden('id');

        $form->addSelect('schedule_id', 'Schedule', $this->scheduleRepository->findAllForSelectBox())
             ->setRequired('The schedule is required');

        $form->addText('venue', 'Venue')
             ->setRequired('The venue is required');

        $form->addSubmit('save', 'Save');

        $form->onSuccess[] = [$this, 'formSuccess'];

        return $form;
    }

    public function formSuccess(Form $form, ArrayHash $values)
    {
        $schedule = $this->scheduleRepository->getById((int) $values->schedule_id);

        if ($values->id === '') {
            $raceEvent = new RaceEvent(
                $schedule,
                $values->venue
            );

            $this->raceEventRepository->save($raceEvent);
            $this->getPresenter()->flashMessage('The new event is saved', 'success');
        }

        if ($values->id !== '') {
            $raceEvent = $this->raceEventRepository->getById((int) $values->id);

            $raceEvent->setSchedule($schedule);
            $raceEvent->setVenue($values->venue);

            $this->raceEventRepository->save($raceEvent);
            $this->getPresenter()->flashMessage('The event is updated', 'info');
        }

        $schedule = $this->scheduleRepository->getById((int) $values->schedule_id);
        $disciplineId = $schedule->getDiscipline()->getId();

        $this->disciplineId = $disciplineId;

        $this->onFinish($this);
    }

    public function render()
    {
        $template = $this->getTemplate();
        $template->setFile(__DIR__ .'/raceEventForm.latte');
        $template->render();
    }

    public function getDisciplineId(): int
    {
        return $this->disciplineId;
    }
}