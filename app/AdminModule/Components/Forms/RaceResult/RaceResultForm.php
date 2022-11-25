<?php
declare(strict_types=1);

namespace App\AdminModule\Components\Forms\RaceResult;

use App\Model\Entities\RaceResult\RaceResult;
use App\Model\Repositories\AthleteRepository;
use App\Model\Repositories\DisciplineRepository;
use App\Model\Repositories\RaceEventRepository;
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

    private RaceEventRepository $raceEventRepository;

    private AthleteRepository $athleteRepository;

    private RacePositionRepository $racePositionRepository;

    private RaceResultRepository $raceResultRepository;

    private ScheduleRepository $scheduleRepository;

    private DisciplineRepository $disciplineRepository;

    private int $raceEventId;

    public function __construct(
        RaceEventRepository $raceEventRepository,
        AthleteRepository $athleteRepository,
        RacePositionRepository $racePositionRepository,
        RaceResultRepository $raceResultRepository,
        ScheduleRepository $scheduleRepository,
        DisciplineRepository $disciplineRepository,
        int $raceEventId
    )
    {
        $this->raceEventRepository = $raceEventRepository;
        $this->athleteRepository = $athleteRepository;
        $this->racePositionRepository = $racePositionRepository;
        $this->raceResultRepository = $raceResultRepository;
        $this->scheduleRepository = $scheduleRepository;
        $this->disciplineRepository = $disciplineRepository;
        $this->raceEventId = $raceEventId;
    }

    public function createComponentForm(): Form
    {
        $form = new Form();

        $form->addHidden('id');

        $form->addSelect('race_event_id', 'Event', $this->raceEventRepository->findAllForSelectBox())
             ->setPrompt('--Choose event-')
             ->setRequired('The event is required');

        $athletesArray = $this->athleteRepository->findAllForSelectBoxBySportIdAndGenderId($this->getSportId(), $this->getGenderId());
        $form->addSelect('athlete_id', 'Athlete', $athletesArray)
             ->setPrompt('--Choose athlete--')
             ->setRequired('The athlete is required');

        $positionsArray = $this->racePositionRepository->findAllForSelectBoxBySportId($this->getSportId());
        $form->addSelect('race_position_id', 'Race Position', $positionsArray)
             ->setPrompt('--Choose race position--')
             ->setRequired('The race position is required');

        $form->addSubmit('save', 'Save');

        $form->onSuccess[] = [$this, 'formSuccess'];

        return $form;
    }

    public function formSuccess(Form $form, ArrayHash $values)
    {
        $raceEvent = $this->raceEventRepository->getById((int) $values->race_event_id);
        $athlete = $this->athleteRepository->getById((int) $values->athlete_id);
        $racePosition = $this->racePositionRepository->getById((int) $values->race_position_id);

        if ($values->id === '') {
            $raceResult = new RaceResult(
                $raceEvent,
                $athlete,
                $racePosition
            );

            $this->raceResultRepository->save($raceResult);
            $this->getPresenter()->flashMessage('The new record is saved', 'success');
        }

        if ($values->id !== '') {
            $raceResult = $this->raceResultRepository->getById((int) $values->id);

            $raceResult->setRaceEvent($raceEvent);
            $raceResult->setAthlete($athlete);
            $raceResult->setRacePosition($racePosition);

            $this->raceResultRepository->save($raceResult);
            $this->getPresenter()->flashMessage('The record is updated', 'info');
        }

        $this->onFinish($this);
    }

    public function render()
    {
        $template = $this->getTemplate();
        $template->setFile(__DIR__ .'/raceResultForm.latte');
        $template->render();
    }

    public function getSportId(): int
    {
        $raceEvent = $this->raceEventRepository->getById($this->raceEventId);

        return $raceEvent->getSchedule()->getSport()->getId();
    }

    private function getGenderId(): int
    {
        $raceEvent = $this->raceEventRepository->getById($this->raceEventId);
        $schedule = $this->scheduleRepository->getById($raceEvent->getSchedule()->getId());
        $discipline = $this->disciplineRepository->getById($schedule->getDiscipline()->getId());

        return $discipline->getGender()->getId();
    }
}