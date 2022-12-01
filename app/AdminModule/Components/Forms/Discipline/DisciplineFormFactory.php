<?php
declare(strict_types=1);

namespace App\AdminModule\Components\Forms\Discipline;

use App\Model\Repositories\DisciplineRepository;
use App\Model\Repositories\GenderRepository;
use App\Model\Repositories\SportRepository;

class DisciplineFormFactory
{
    private SportRepository $sportRepository;

    private DisciplineRepository $disciplineRepository;

    public function __construct(
        SportRepository $sportRepository,
        DisciplineRepository $disciplineRepository
    )
    {
        $this->sportRepository = $sportRepository;
        $this->disciplineRepository = $disciplineRepository;
    }

    public function create(): DisciplineForm
    {
        return new DisciplineForm($this->sportRepository, $this->disciplineRepository);
    }
}