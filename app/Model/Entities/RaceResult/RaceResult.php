<?php
declare(strict_types=1);

namespace App\Model\Entities\RaceResult;

use App\Model\Entities\Athlete\Athlete;
use App\Model\Entities\RacePoint\RacePoint;
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
     * @ORM\ManyToOne(targetEntity="App\Model\Entities\Schedule\Schedule", fetch="EAGER")
     * @ORM\JoinColumn(name="schedule_id", referencedColumnName="id", nullable=false)
     */
    private Schedule $schedule;

    /**
     * @ORM\ManyToOne(targetEntity="App\Model\Entities\Athlete\Athlete", fetch="EAGER")
     * @ORM\JoinColumn(name="athlete_id", referencedColumnName="id", nullable=false)
     */
    private Athlete $athlete;

    /**
     * @ORM\ManyToOne(targetEntity="App\Model\Entities\RacePosition\RacePosition", fetch="EAGER")
     * @ORM\JoinColumn(name="race_point_id", referencedColumnName="id", nullable=false)
     */
    private RacePoint $racePoint;

    public function __construct(Schedule $schedule, Athlete $athlete, RacePoint $racePoint)
    {
        $this->schedule = $schedule;
        $this->athlete = $athlete;
        $this->racePoint = $racePoint;
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
     * @return RacePoint
     */
    public function getRacePoint(): RacePoint
    {
        return $this->racePoint;
    }

    /**
     * @param RacePoint $racePoint
     */
    public function setRacePoint(RacePoint $racePoint): void
    {
        $this->racePoint = $racePoint;
    }
}