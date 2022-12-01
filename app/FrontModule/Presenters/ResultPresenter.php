<?php
declare(strict_types=1);

namespace App\FrontModule\Presenters;

use App\Model\Entities\Gender\Gender;
use App\Model\Repositories\AthleteRepository;
use App\Model\Repositories\DisciplineRepository;
use App\Model\Repositories\GenderRepository;
use App\Model\Repositories\RacePointRepository;
use App\Model\Repositories\RaceResultRepository;
use App\Model\Repositories\ScheduleRepository;
use App\Model\Repositories\SportRepository;
use Nette\Application\UI\Presenter;

class ResultPresenter extends Presenter
{
    private SportRepository $sportRepository;

    private DisciplineRepository $disciplineRepository;

    private GenderRepository $genderRepository;

    private RaceResultRepository $raceResultRepository;

    private ScheduleRepository $scheduleRepository;

    public function __construct(
        SportRepository $sportRepository,
        DisciplineRepository $disciplineRepository,
        GenderRepository $genderRepository,
        RaceResultRepository $raceResultRepository,
        ScheduleRepository $scheduleRepository
    )
    {
        $this->sportRepository = $sportRepository;
        $this->disciplineRepository = $disciplineRepository;
        $this->genderRepository = $genderRepository;
        $this->raceResultRepository = $raceResultRepository;
        $this->scheduleRepository = $scheduleRepository;
    }

    public function renderDefault(int $sportId = null, int $genderId = null, int $disciplineId = null, string $type = null)
    {
        $disciplines = $this->disciplineRepository->findAllBySportIdAndGenderId((int) $sportId, (int) $genderId);

        $this->template->sport = null;
        $this->template->gender = null;

        if ($sportId !== null) {
            $this->template->disciplines = $disciplines;
            $this->template->sport = $this->sportRepository->getById($sportId);
        }

        $this->template->sports = $this->sportRepository->findAll();
        $this->template->sportId = $sportId;

        $this->template->genders = $this->genderRepository->findAll();
        $this->template->genderId = $genderId;

        $this->template->totalResults = $this->raceResultRepository->getTotalResultsBySportIdAndGenderId((int) $sportId,  (int) $genderId);

        $this->template->totalResultsByDiscipline = $this->raceResultRepository->getTotalResultsByDisciplineId((int) $disciplineId, (int) $genderId);

        $this->template->gender = $this->genderRepository->getById((int) $genderId);

        $this->template->disciplineId = $disciplineId;
        $this->template->discipline = $this->disciplineRepository->getById((int) $disciplineId);
     }

     public function renderFinishedRace(int $disciplineId)
     {
         $this->template->discipline = $this->disciplineRepository->getById($disciplineId);
         $this->template->schedules = $this->scheduleRepository->findAllByDisciplineId($disciplineId);
     }
}