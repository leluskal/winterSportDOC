<?php
declare(strict_types=1);

namespace App\AdminModule\Components\Forms\RacePosition;

use App\Model\Repositories\RacePositionRepository;
use App\Model\Repositories\SportRepository;

class RacePositionFormFactory
{
    private SportRepository $sportRepository;

    private RacePositionRepository $racePositionRepository;

    public function __construct(SportRepository $sportRepository, RacePositionRepository $racePositionRepository)
    {
        $this->sportRepository = $sportRepository;
        $this->racePositionRepository = $racePositionRepository;
    }

    public function create(): RacePositionForm
    {
        return new RacePositionForm($this->sportRepository, $this->racePositionRepository);
    }

}