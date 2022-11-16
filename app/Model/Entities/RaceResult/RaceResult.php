<?php
declare(strict_types=1);

namespace App\Model\Entities\RaceResult;

use App\Model\Entities\Athlete\Athlete;
use App\Model\Entities\RacePosition\RacePosition;
use App\Model\Entities\Schedule\Schedule;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="race_result")
 */
class RaceResult
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
     * @ORM\ManyToOne(targetEntity="App\Model\Entities\Athlete\Athlete")
     * @ORM\JoinColumn(name="athlete_id", referencedColumnName="id", nullable=false)
     */
    private Athlete $athlete;

    /**
     * @ORM\ManyToOne(targetEntity="App\Model\Entities\RacePosition\RacePosition")
     * @ORM\JoinColumn(name="race_position_id", referencedColumnName="id", nullable=false)
     */
    private RacePosition $racePosition;

    public function __construct(Schedule $schedule, Athlete $athlete, RacePosition $racePosition)
    {
        $this->schedule = $schedule;
        $this->athlete = $athlete;
        $this->racePosition = $racePosition;
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
     * @return Athlete
     */
    public function getAthlete(): Athlete
    {
        return $this->athlete;
    }

    /**
     * @param Athlete $athlete
     */
    public function setAthlete(Athlete $athlete): void
    {
        $this->athlete = $athlete;
    }

    /**
     * @return RacePosition
     */
    public function getRacePosition(): RacePosition
    {
        return $this->racePosition;
    }

    /**
     * @param RacePosition $racePosition
     */
    public function setRacePosition(RacePosition $racePosition): void
    {
        $this->racePosition = $racePosition;
    }
}