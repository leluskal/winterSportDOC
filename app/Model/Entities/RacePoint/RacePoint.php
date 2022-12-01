<?php
declare(strict_types=1);

namespace App\Model\Entities\RacePoint;

use App\Model\Entities\Discipline\Discipline;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 *@ORM\Table(name="race_point")
 */
class RacePoint
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private int $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Model\Entities\Discipline\Discipline")
     * @ORM\JoinColumn(name="discipline_id", referencedColumnName="id", nullable=false)
     */
    private Discipline $discipline;


    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private int $position;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private int $points;

    public function __construct(Discipline $discipline, int $position, int $points)
    {
        $this->discipline = $discipline;
        $this->position = $position;
        $this->points = $points;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return Discipline
     */
    public function getDiscipline(): Discipline
    {
        return $this->discipline;
    }

    /**
     * @param Discipline $discipline
     */
    public function setDiscipline(Discipline $discipline): void
    {
        $this->discipline = $discipline;
    }

    /**
     * @return int
     */
    public function getPosition(): int
    {
        return $this->position;
    }

    /**
     * @param int $position
     */
    public function setPosition(int $position): void
    {
        $this->position = $position;
    }

    /**
     * @return int
     */
    public function getPoints(): int
    {
        return $this->points;
    }

    /**
     * @param int $points
     */
    public function setPoints(int $points): void
    {
        $this->points = $points;
    }
}