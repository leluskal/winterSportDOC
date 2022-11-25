<?php
declare(strict_types=1);

namespace App\Model\Entities\RaceEvent;

use App\Model\Entities\Schedule\Schedule;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="race_event")
 */
class RaceEvent
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private int $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Model\Entities\Schedule\Schedule")
     * @ORM\JoinColumn(name="schedule_id", referencedColumnName="id", nullable=false)
     */
    private Schedule $schedule;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private string $venue;

    public function __construct(Schedule $schedule, string $venue)
    {
        $this->schedule = $schedule;
        $this->venue = $venue;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return Schedule
     */
    public function getSchedule(): Schedule
    {
        return $this->schedule;
    }

    /**
     * @param Schedule $schedule
     */
    public function setSchedule(Schedule $schedule): void
    {
        $this->schedule = $schedule;
    }

    /**
     * @return string
     */
    public function getVenue(): string
    {
        return $this->venue;
    }

    /**
     * @param string $venue
     */
    public function setVenue(string $venue): void
    {
        $this->venue = $venue;
    }
}