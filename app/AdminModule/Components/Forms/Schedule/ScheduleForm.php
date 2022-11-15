<?php
declare(strict_types=1);

namespace App\AdminModule\Components\Forms\Schedule;

use App\Model\Entities\Schedule\Schedule;
use App\Model\Repositories\DisciplineRepository;
use App\Model\Repositories\ScheduleRepository;
use DateTime;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\SmartObject;
use Nette\Utils\ArrayHash;

class ScheduleForm extends Control
{
    use SmartObject;

    public array $onFinish;

    private int $disciplineId;

    private DisciplineRepository $disciplineRepository;

    private ScheduleRepository $scheduleRepository;

    public function __construct(DisciplineRepository $disciplineRepository, ScheduleRepository $scheduleRepository)
    {
        $this->disciplineRepository = $disciplineRepository;
        $this->scheduleRepository = $scheduleRepository;
    }

    public function createComponentForm(): Form
    {
        $form = new Form();

        $form->addHidden('id');

        $form->addSelect('discipline_id', 'Sport Discipline', $this->disciplineRepository->findAllForSelectBox())
             ->setRequired('The discipline is required');

        $form->addText('event_date', 'Event Date')
            ->setHtmlType('datetime-local')
            ->setRequired('The event date us required');

        $form->addText('event_place', 'Event Place')
             ->setRequired('The event place is required');

        $form->addCheckbox('seen', 'Seen');

        $form->addSubmit('save', 'Save');

        $form->onSuccess[] = [$this, 'formSuccess'];

        return $form;
    }

    public function formSuccess(Form $form, ArrayHash $values)
    {
        $discipline = $this->disciplineRepository->getById((int) $values->discipline_id);

        if ($values->id === '') {
            $schedule = new Schedule(
                $discipline,
                DateTime::createFromFormat('Y-m-d\TH:i', $values->event_date),
                $values->event_place,
                $values->seen
            );

            $this->scheduleRepository->save($schedule);
            $this->getPresenter()->flashMessage('The new schedule record is saved', 'success');
        }

        if ($values->id !== '') {
            $schedule = $this->scheduleRepository->getById((int) $values->id);

            $schedule->setDiscipline($discipline);
            $schedule->setEventDate(DateTime::createFromFormat('Y-m-d\TH:i', $values->event_date));
            $schedule->setEventPlace($values->event_place);
            $schedule->setSeen($values->seen);

            $this->scheduleRepository->save($schedule);
            $this->getPresenter()->flashMessage('The schedule record is updated', 'info');
        }

        $this->disciplineId = $values->discipline_id;

        $this->onFinish($this);
    }

    public function render()
    {
        $template = $this->getTemplate();
        $template->setFile(__DIR__ .'/scheduleForm.latte');
        $template->render();
    }

    public function getDisciplineId(): int
    {
        return $this->disciplineId;
    }
}