<?php
declare(strict_types=1);

namespace App\Model\Entities\RaceResult;

use App\Model\Entities\Athlete\Athlete;
use App\Model\Entities\RaceEvent\RaceEvent;
use App\Model\Entities\RacePosition\RacePosition;
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
     * @ORM\ManyToOne(targetEntity="App\Model\Entities\RaceEvent\RaceEvent")
     * @ORM\JoinColumn(name="race_event_id", referencedColumnName="id", nullable=false)
     */
    private RaceEvent $raceEvent;

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

    public function __construct(RaceEvent $raceEvent, Athlete $athlete, RacePosition $racePosition)
    {
        $this->raceEvent = $raceEvent;
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
     * @return RaceEvent
     */
    public function getRaceEvent(): RaceEvent
    {
        return $this->raceEvent;
    }

    /**
     * @param RaceEvent $raceEvent
     */
    public function setRaceEvent(RaceEvent $raceEvent): void
    {
        $this->raceEvent = $raceEvent;
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