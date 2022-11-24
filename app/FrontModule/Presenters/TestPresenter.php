<?php
declare(strict_types=1);

namespace App\FrontModule\Presenters;

use App\Model\Entities\Gender\Gender;
use App\Model\Repositories\AthleteRepository;
use App\Model\Repositories\DisciplineRepository;
use App\Model\Repositories\GenderRepository;
use App\Model\Repositories\RacePositionRepository;
use App\Model\Repositories\SportRepository;
use Nette\Application\UI\Presenter;

class TestPresenter extends Presenter
{
    private SportRepository $sportRepository;

    private DisciplineRepository $disciplineRepository;

    private GenderRepository $genderRepository;

    public function __construct(
        SportRepository $sportRepository,
        DisciplineRepository $disciplineRepository,
        GenderRepository $genderRepository
    )
    {
        $this->sportRepository = $sportRepository;
        $this->disciplineRepository = $disciplineRepository;
        $this->genderRepository = $genderRepository;
    }

    public function renderDefault(int $sportId = null, int $genderId = null)
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

     }
}