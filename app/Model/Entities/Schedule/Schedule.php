<?php
declare(strict_types=1);

namespace App\Model\Entities\Schedule;

use App\Model\Entities\Discipline\Discipline;
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
     * @ORM\ManyToOne(targetEntity="App\Model\Entities\Discipline\Dicsipline")
     * @ORM\JoinColumn(name="discipline_id", referencedColumnName="id", nullable=false)
     */
    private Discipline $discipline;

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

    public function __construct(Discipline $discipline, DateTime $eventDate, string $eventPlace, bool $seen)
    {
        $this->discipline = $discipline;
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