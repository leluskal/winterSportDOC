<?php
declare(strict_types=1);

namespace App\FrontModule\Presenters;

use App\Model\Repositories\DisciplineGenderRepository;
use App\Model\Repositories\DisciplineRepository;
use App\Model\Repositories\GenderRepository;
use App\Model\Repositories\RaceResultRepository;
use App\Model\Repositories\ScheduleRepository;
use App\Model\Repositories\SportRepository;
use App\Presenters\BasePresenter;

class ResultPresenter extends BasePresenter
{
    private SportRepository $sportRepository;

    private DisciplineRepository $disciplineRepository;

    private GenderRepository $genderRepository;

    private RaceResultRepository $raceResultRepository;

    private ScheduleRepository $scheduleRepository;

    private DisciplineGenderRepository $disciplineGenderRepository;

    public function __construct(
        SportRepository $sportRepository,
        DisciplineRepository $disciplineRepository,
        GenderRepository $genderRepository,
        RaceResultRepository $raceResultRepository,
        ScheduleRepository $scheduleRepository,
        DisciplineGenderRepository $disciplineGenderRepository
    )
    {
        $this->sportRepository = $sportRepository;
        $this->disciplineRepository = $disciplineRepository;
        $this->genderRepository = $genderRepository;
        $this->raceResultRepository = $raceResultRepository;
        $this->scheduleRepository = $scheduleRepository;
        $this->disciplineGenderRepository = $disciplineGenderRepository;
    }

    public function renderDefault(int $sportId = null, int $genderId = null, int $disciplineId = null, int $disciplineGenderId = null, bool $overallStandings = false)
    {
        $disciplineGenders = $this->disciplineGenderRepository->findAllBySportIdAndGenderId((int) $sportId, (int) $genderId);

        $this->template->sport = null;
        $this->template->gender = null;

        if ($sportId !== null) {
            $this->template->disciplineGenders = $disciplineGenders;
            $this->template->sport = $this->sportRepository->getById($sportId);
        }

        $this->template->sports = $this->sportRepository->findAll();
        $this->template->sportId = $sportId;

        $this->template->genders = $this->genderRepository->findAll();
        $this->template->genderId = $genderId;
        $this->template->gender = $this->genderRepository->getById((int) $genderId);

        $this->template->totalResults = $this->raceResultRepository->getTotalResultsBySportIdAndGenderId((int) $sportId,  (int) $genderId);
        $this->template->totalResultsByDiscipline = $this->raceResultRepository->getTotalResultsByDisciplineIdAndGenderId((int) $disciplineId, (int) $genderId);

        $this->template->disciplineGenderId = $disciplineGenderId;

        if ($disciplineGenderId !== null) {
            $this->template->disciplineGender = $this->disciplineGenderRepository->getById($disciplineGenderId);

        }

        $this->template->overallStandings = $overallStandings;
        $this->template->year = $this->year;
     }


     public function renderRace(int $disciplineGenderId)
     {
         $disciplineGender = $this->disciplineGenderRepository->getById($disciplineGenderId);
         $this->template->disciplineGender = $disciplineGender;

         $disciplineId = $disciplineGender->getDiscipline()->getId();
         $genderId = $disciplineGender->getGender()->getId();
         $this->template->schedules = $this->scheduleRepository->findAllByDisciplineIdAndGenderId($disciplineId, $genderId);
     }

     public function renderRaceResult(int $scheduleId)
     {
        $this->template->schedule = $this->scheduleRepository->getById($scheduleId);
        $this->template->raceResults = $this->raceResultRepository->findAllByScheduleId($scheduleId);
     }
}