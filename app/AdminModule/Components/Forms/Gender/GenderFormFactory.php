<?php
declare(strict_types=1);

namespace App\AdminModule\Components\Forms\Gender;

use App\Model\Repositories\GenderRepository;

class GenderFormFactory
{
    private GenderRepository $genderRepository;

    public function __construct(GenderRepository $genderRepository)
    {
        $this->genderRepository = $genderRepository;
    }

    public function create(): GenderForm
    {
        return new GenderForm($this->genderRepository);
    }
}