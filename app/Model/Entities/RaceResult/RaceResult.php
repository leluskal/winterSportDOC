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
     * @ORM\ManyToOne(targetEntity="App\Model\Entities\RacePoint\RacePoint", fetch="EAGER")
     * @ORM\JoinColumn(name="race_point_id", referencedColumnName="id", nullable=false)
     */
    private RacePoint $racePoint;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private int $year;

    public function __construct(Schedule $schedule, Athlete $athlete, RacePoint $racePoint, int $year)
    {
        $this->schedule = $schedule;
        $this->athlete = $athlete;
        $this->racePoint = $racePoint;
        $this->year = $year;
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

    /**
     * @return int
     */
    public function getYear(): int
    {
        return $this->year;
    }

    /**
     * @param int $year
     */
    public function setYear(int $year): void
    {
        $this->year = $year;
    }
}