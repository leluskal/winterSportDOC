<?php
declare(strict_types=1);

namespace App\AdminModule\Components\Forms\Sport;

use App\Model\Repositories\SportRepository;

class SportFormFactory
{
    private SportRepository $sportRepository;

    public function __construct(SportRepository $sportRepository)
    {
        $this->sportRepository = $sportRepository;
    }

    public function create(): SportForm
    {
        return new SportForm($this->sportRepository);
    }
}