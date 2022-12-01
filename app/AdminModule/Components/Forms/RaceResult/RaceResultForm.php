<?php
declare(strict_types=1);

namespace App\AdminModule\Components\Forms\RaceResult;

use App\Model\Entities\RaceResult\RaceResult;
use App\Model\Entities\Schedule\Schedule;
use App\Model\Repositories\AthleteRepository;
use App\Model\Repositories\DisciplineRepository;
use App\Model\Repositories\RacePositionRepository;
use App\Model\Repositories\RaceResultRepository;
use App\Model\Repositories\ScheduleRepository;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\SmartObject;
use Nette\Utils\ArrayHash;

class RaceResultForm extends Control
{
    use SmartObject;

    public array $onFinish;

    private AthleteRepository $athleteRepository;

    private RacePositionRepository $racePositionRepository;

    private RaceResultRepository $raceResultRepository;

    private ScheduleRepository $scheduleRepository;

    private DisciplineRepository $disciplineRepository;

    private Schedule $schedule;

    public function __construct(
        AthleteRepository $athleteRepository,
        RacePositionRepository $racePositionRepository,
        RaceResultRepository $raceResultRepository,
        ScheduleRepository $scheduleRepository,
        DisciplineRepository $disciplineRepository,
        Schedule $schedule
    )
    {
        $this->athleteRepository = $athleteRepository;
        $this->racePositionRepository = $racePositionRepository;
        $this->raceResultRepository = $raceResultRepository;
        $this->scheduleRepository = $scheduleRepository;
        $this->disciplineRepository = $disciplineRepository;
        $this->schedule = $schedule;
    }

    public function createComponentForm(): Form
    {
        $form = new Form();

        $form->addHidden('id');

        $form->addSelect('schedule_id', 'Schedule', $this->scheduleRepository->findAllForSelectBoxBySportId($this->schedule->getSport()->getId()))
             ->setPrompt('--Choose schedule--')
             ->setRequired('The schedule is required');

        $athletesArray = $this->athleteRepository->findAllForSelectBoxBySportIdAndGenderId(
            $this->schedule->getSport()->getId(),
            $this->schedule->getDiscipline()->getGender()->getId()
        );
        $form->addSelect('athlete_id', 'Athlete', $athletesArray)
             ->setPrompt('--Choose athlete--')
             ->setRequired('The athlete is required');

        $positionsArray = $this->racePositionRepository->findAllForSelectBoxBySportId($this->schedule->getSport()->getId());
        $form->addSelect('race_position_id', 'Race Position', $positionsArray)
             ->setPrompt('--Choose race position--')
             ->setRequired('The race position is required');

        $form->addSubmit('save', 'Save');

        $form->onSuccess[] = [$this, 'formSuccess'];

        return $form;
    }

    public function formSuccess(Form $form, ArrayHash $values)
    {
        $schedule = $this->scheduleRepository->getById((int) $values->schedule_id);
        $athlete = $this->athleteRepository->getById((int) $values->athlete_id);
        $racePosition = $this->racePositionRepository->getById((int) $values->race_position_id);

        if ($values->id === '') {
            $raceResult = new RaceResult(
                $schedule,
                $athlete,
                $racePosition
            );

            $this->raceResultRepository->save($raceResult);
            $this->getPresenter()->flashMessage('The new record is saved', 'success');
        }

        if ($values->id !== '') {
            $raceResult = $this->raceResultRepository->getById((int) $values->id);

            $raceResult->setSchedule($schedule);
            $raceResult->setAthlete($athlete);
            $raceResult->setRacePosition($racePosition);

            $this->raceResultRepository->save($raceResult);
            $this->getPresenter()->flashMessage('The record is updated', 'info');
        }

        $this->schedule = $schedule;

        $this->onFinish($this);
    }

    public function render()
    {
        $template = $this->getTemplate();
        $template->setFile(__DIR__ .'/raceResultForm.latte');
        $template->render();
    }

    public function getSchedule(): Schedule
    {
        return $this->schedule;
    }
}