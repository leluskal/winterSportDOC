<?php
declare(strict_types=1);

namespace App\Model\Entities\Discipline;

use App\Model\Entities\Sport\Sport;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="discipline")
 */
class Discipline
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private int $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Model\Entities\Sport\Sport", fetch="EAGER")
     * @ORM\JoinColumn(name="sport_id", referencedColumnName="id", nullable=false)
     */
    private Sport $sport;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private string $name;

    /**
     * @var bool
     * @ORM\Column(type="integer")
     *
     */
    private bool $worldCupPoints;

    public function __construct(Sport $sport, string $name, bool $worldCupPoints)
    {
        $this->sport = $sport;
        $this->name = $name;
        $this->worldCupPoints = $worldCupPoints;
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
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return bool
     */
    public function isWorldCupPoints(): bool
    {
        return $this->worldCupPoints;
    }

    /**
     * @param bool $worldCupPoints
     */
    public function setWorldCupPoints(bool $worldCupPoints): void
    {
        $this->worldCupPoints = $worldCupPoints;
    }
}