<?php
declare(strict_types=1);

namespace App\Model\Entities\Discipline;

use App\Model\Entities\Gender\Gender;
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
     * @ORM\ManyToOne(targetEntity="App\Model\Entities\Sport\Sport")
     * @ORM\JoinColumn(name="sport_id", referencedColumnName="id", nullable=false)
     */
    private Sport $sport;

    /**
     * @ORM\ManyToOne(targetEntity="App\Model\Entities\Gender\Gender")
     * @ORM\JoinColumn(name="gender_id", referencedColumnName="id", nullable=false)
     */
    private Gender $gender;

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

    public function __construct(Sport $sport, Gender $gender, string $name, bool $worldCupPoints)
    {
        $this->sport = $sport;
        $this->gender = $gender;
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
     * @return Gender
     */
    public function getGender(): Gender
    {
        return $this->gender;
    }

    /**
     * @param Gender $gender
     */
    public function setGender(Gender $gender): void
    {
        $this->gender = $gender;
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