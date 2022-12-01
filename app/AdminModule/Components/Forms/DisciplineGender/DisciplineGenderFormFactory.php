<?php
declare(strict_types=1);

namespace App\AdminModule\Components\Forms\DisciplineGender;

use App\Model\Repositories\DisciplineGenderRepository;
use App\Model\Repositories\DisciplineRepository;
use App\Model\Repositories\GenderRepository;

class DisciplineGenderFormFactory
{
    private DisciplineRepository $disciplineRepository;

    private GenderRepository $genderRepository;

    private DisciplineGenderRepository $disciplineGenderRepository;

    public function __construct(
        DisciplineRepository $disciplineRepository,
        GenderRepository $genderRepository,
        DisciplineGenderRepository $disciplineGenderRepository
    )
    {
        $this->disciplineRepository = $disciplineRepository;
        $this->genderRepository = $genderRepository;
        $this->disciplineGenderRepository = $disciplineGenderRepository;
    }

    public function create(): DisciplineGenderForm
    {
        return new DisciplineGenderForm($this->disciplineRepository, $this->genderRepository, $this->disciplineGenderRepository);
    }
}