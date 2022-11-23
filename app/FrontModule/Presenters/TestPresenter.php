<?php
declare(strict_types=1);

namespace App\FrontModule\Presenters;

use App\Model\Repositories\AthleteRepository;
use App\Model\Repositories\DisciplineRepository;
use App\Model\Repositories\RacePositionRepository;
use App\Model\Repositories\SportRepository;
use Nette\Application\UI\Presenter;

class TestPresenter extends Presenter
{

    private SportRepository $sportRepository;

    private DisciplineRepository $disciplineRepository;

    private RacePositionRepository $racePositionRepository;

    private AthleteRepository $athleteRepository;

    public function __construct(
        SportRepository $sportRepository,
        DisciplineRepository $disciplineRepository,
        RacePositionRepository $racePositionRepository,
        AthleteRepository $athleteRepository
    )
    {
        $this->sportRepository = $sportRepository;
        $this->disciplineRepository = $disciplineRepository;
        $this->racePositionRepository = $racePositionRepository;
        $this->athleteRepository = $athleteRepository;
    }

    public function renderDefault(int $sportId = null)
    {
        $disciplines = $this->disciplineRepository->findAllBySportId((int) $sportId);

        $this->template->sport = null;

        if ($sportId !== null) {
            $this->template->disciplines = $disciplines;
            $this->template->sport = $this->sportRepository->getById($sportId);
        }

        $this->template->sports = $this->sportRepository->findAll();
        $this->template->sportId = $sportId;

     }
}