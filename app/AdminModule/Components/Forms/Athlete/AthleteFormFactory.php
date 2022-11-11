<?php
declare(strict_types=1);

namespace App\AdminModule\Components\Forms\Athlete;

use App\Model\Repositories\AthleteRepository;
use App\Model\Repositories\GenderRepository;
use App\Model\Repositories\SportRepository;

class AthleteFormFactory
{
    private GenderRepository $genderRepository;

    private SportRepository $sportRepository;

    private AthleteRepository $athleteRepository;

    public function __construct(
        GenderRepository $genderRepository,
        SportRepository $sportRepository,
        AthleteRepository $athleteRepository
    )
    {
        $this->genderRepository = $genderRepository;
        $this->sportRepository = $sportRepository;
        $this->athleteRepository = $athleteRepository;
    }

    public function create(): AthleteForm
    {
        return new AthleteForm($this->genderRepository, $this->sportRepository, $this->athleteRepository);
    }
}