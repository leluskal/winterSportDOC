<?php
declare(strict_types=1);

namespace App\AdminModule\Components\Forms\Schedule;

use App\Model\Entities\Schedule\Schedule;
use App\Model\Entities\Sport\Sport;
use App\Model\Repositories\DisciplineRepository;
use App\Model\Repositories\ScheduleRepository;
use App\Model\Repositories\SportRepository;
use DateTime;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\SmartObject;
use Nette\Utils\ArrayHash;

class ScheduleForm extends Control
{
    use SmartObject;

    public array $onFinish;

    private int $sportId;

    private SportRepository $sportRepository;

    private DisciplineRepository $disciplineRepository;

    private ScheduleRepository $scheduleRepository;

    public function __construct(
        SportRepository $sportRepository,
        DisciplineRepository $disciplineRepository,
        ScheduleRepository $scheduleRepository
    )
    {
        $this->sportRepository = $sportRepository;
        $this->disciplineRepository = $disciplineRepository;
        $this->scheduleRepository = $scheduleRepository;
    }

    public function setSportId(int $sportId): void
    {
        $this->sportId = $sportId;
    }

    public function createComponentForm(): Form
    {
        $form = new Form();

        $form->addHidden('id');

        $form->addSelect('sport_id', 'Sport', $this->sportRepository->findAllForSelectBox())
             ->setRequired('The sport is required');

        $form->addSelect('discipline_id', 'Sport Discipline', $this->disciplineRepository->findAllForSelectBoxBySportId($this->sportId))
             ->setPrompt('--Choose discipline--')
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
        $sport = $this->sportRepository->getById((int) $values->sport_id);
        $discipline = $this->disciplineRepository->getById((int) $values->discipline_id);

        if ($values->id === '') {
            $schedule = new Schedule(
                $sport,
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

            $schedule->setSport($sport);
            $schedule->setDiscipline($discipline);
            $schedule->setEventDate(DateTime::createFromFormat('Y-m-d\TH:i', $values->event_date));
            $schedule->setEventPlace($values->event_place);
            $schedule->setSeen($values->seen);

            $this->scheduleRepository->save($schedule);
            $this->getPresenter()->flashMessage('The schedule record is updated', 'info');
        }

        $this->sportId = $values->sport_id;

        $this->onFinish($this);
    }

    public function render()
    {
        $template = $this->getTemplate();
        $template->setFile(__DIR__ .'/scheduleForm.latte');
        $template->render();
    }

    public function getSportId(): int
    {
        return $this->sportId;
    }
}