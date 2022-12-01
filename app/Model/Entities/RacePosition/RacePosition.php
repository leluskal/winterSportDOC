<?php
declare(strict_types=1);

namespace App\Model\Entities\RacePosition;

use App\Model\Entities\Discipline\Discipline;
use App\Model\Entities\Sport\Sport;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 *@ORM\Table(name="race_position")
 */
class RacePosition
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private int $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Model\Entities\Sport\Sport")
     * @ORM\JoinColumn(name="sport_id", referencedColumnName="id", nullable=false)
     */
    private Sport $sport;

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
    private int $point;

    public function __construct(Sport $sport, Discipline $discipline, int $position, int $point)
    {
        $this->sport = $sport;
        $this->discipline = $discipline;
        $this->position = $position;
        $this->point = $point;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return Sport
     */
    public function getSport(): Sport
    {
        return $this->sport;
    }

    /**
     * @param Sport $sport
     */
    public function setSport(Sport $sport): void
    {
        $this->sport = $sport;
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
    public function getPoint(): int
    {
        return $this->point;
    }

    /**
     * @param int $point
     */
    public function setPoint(int $point): void
    {
        $this->point = $point;
    }
}