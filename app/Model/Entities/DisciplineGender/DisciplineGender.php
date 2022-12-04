<?php
declare(strict_types=1);

namespace App\Model\Entities\DisciplineGender;

use App\Model\Entities\Discipline\Discipline;
use App\Model\Entities\Gender\Gender;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="discipline_gender")
 */
class DisciplineGender
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private int $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Model\Entities\Discipline\Discipline", fetch="EAGER")
     * @ORM\JoinColumn(name="discipline_id", referencedColumnName="id", nullable=false)
     */
    private Discipline $discipline;

    /**
     * @ORM\ManyToOne(targetEntity="App\Model\Entities\Gender\Gender", fetch="EAGER")
     * @ORM\JoinColumn(name="gender_id", referencedColumnName="id", nullable=false)
     */
    private Gender $gender;

    public function __construct(Discipline $discipline, Gender $gender)
    {
        $this->discipline = $discipline;
        $this->gender = $gender;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
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
}