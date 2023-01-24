<?php
declare(strict_types=1);

namespace App\AdminModule\Components\Forms\Schedule;

use App\Model\Entities\Schedule\Schedule;
use App\Model\Entities\Sport\Sport;
use App\Model\Repositories\DisciplineGenderRepository;
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

    public array $onDelete;

    private int $sportId;

    private SportRepository $sportRepository;

    private DisciplineGenderRepository $disciplineGenderRepository;

    private ScheduleRepository $scheduleRepository;

    public function __construct(
        SportRepository $sportRepository,
        DisciplineGenderRepository $disciplineGenderRepository,
        ScheduleRepository $scheduleRepository
    )
    {
        $this->sportRepository = $sportRepository;
        $this->disciplineGenderRepository = $disciplineGenderRepository;
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

        $form->addSelect('discipline_gender_id', 'Discipline', $this->disciplineGenderRepository->findAllForSelectBoxBySportId($this->sportId))
             ->setPrompt('--Choose discipline--')
             ->setRequired('The discipline is required');

        $form->addText('event_date', 'Event Date')
            ->setHtmlType('datetime-local')
            ->setRequired('The event date us required');

        $form->addText('event_place', 'Event Place')
             ->setRequired('The event place is required');

        $form->addHidden('year');

        $form->addSubmit('save', 'Save');

        $form->addSubmit('delete', 'Delete')
             ->setValidationScope([$form['id']]);

        $form->onSuccess[] = [$this, 'formSuccess'];

        return $form;
    }

    public function formSuccess(Form $form, ArrayHash $values)
    {
        if ($form['delete']->isSubmittedBy()) {
            $schedule = $this->scheduleRepository->getById((int) $values->id);
            $this->scheduleRepository->delete($schedule);
            $this->getPresenter()->flashMessage('The schedule record is deleted', 'info');
            $this->onDelete($this);
        }

        $sport = $this->sportRepository->getById((int) $values->sport_id);
        $disciplineGender = $this->disciplineGenderRepository->getById((int) $values->discipline_gender_id);

        bdump($values->year);

        if ($values->id === '') {
            $schedule = new Schedule(
                $sport,
                $disciplineGender,
                DateTime::createFromFormat('Y-m-d\TH:i', $values->event_date),
                $values->event_place,
                (int) $values->year
            );

            $this->scheduleRepository->save($schedule);
            $this->getPresenter()->flashMessage('The new schedule record is saved', 'success');
        }

        if ($values->id !== '') {
            $schedule = $this->scheduleRepository->getById((int) $values->id);

            $schedule->setSport($sport);
            $schedule->setDisciplineGender($disciplineGender);
            $schedule->setEventDate(DateTime::createFromFormat('Y-m-d\TH:i', $values->event_date));
            $schedule->setEventPlace($values->event_place);
            $schedule->setYear((int) $values->year);

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