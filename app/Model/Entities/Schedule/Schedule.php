<?php
declare(strict_types=1);

namespace App\Model\Entities\Schedule;

use App\Model\Entities\DisciplineGender\DisciplineGender;
use App\Model\Entities\Sport\Sport;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="schedule")
 */
class Schedule
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
     * @ORM\ManyToOne(targetEntity="App\Model\Entities\DisciplineGender\DisciplineGender", fetch="EAGER")
     * @ORM\JoinColumn(name="discipline_gender_id", referencedColumnName="id", nullable=false)
     */
    private DisciplineGender $disciplineGender;

    /**
     * @var DateTime
     * @ORM\Column(type="datetime")
     */
    private DateTime $eventDate;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private string $eventPlace;

    /**
     * @var bool
     * @ORM\Column(type="integer")
     */
    private bool $seen;

    public function __construct(Sport $sport, DisciplineGender $disciplineGender, DateTime $eventDate, string $eventPlace, bool $seen)
    {
        $this->sport = $sport;
        $this->disciplineGender = $disciplineGender;
        $this->eventDate = $eventDate;
        $this->eventPlace = $eventPlace;
        $this->seen = $seen;
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
     * @return DisciplineGender
     */
    public function getDisciplineGender(): DisciplineGender
    {
        return $this->disciplineGender;
    }

    /**
     * @param DisciplineGender $disciplineGender
     */
    public function setDisciplineGender(DisciplineGender $disciplineGender): void
    {
        $this->disciplineGender = $disciplineGender;
    }

    /**
     * @return DateTime
     */
    public function getEventDate(): DateTime
    {
        return $this->eventDate;
    }

    /**
     * @param DateTime $eventDate
     */
    public function setEventDate(DateTime $eventDate): void
    {
        $this->eventDate = $eventDate;
    }

    /**
     * @return string
     */
    public function getEventPlace(): string
    {
        return $this->eventPlace;
    }

    /**
     * @param string $eventPlace
     */
    public function setEventPlace(string $eventPlace): void
    {
        $this->eventPlace = $eventPlace;
    }

    /**
     * @return bool
     */
    public function isSeen(): bool
    {
        return $this->seen;
    }

    /**
     * @param bool $seen
     */
    public function setSeen(bool $seen): void
    {
        $this->seen = $seen;
    }
}