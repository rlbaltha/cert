<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Program
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\ProgramRepository")
 */
class Program
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="school", type="string", length=255, nullable=true)
     */
    private $school;

    /**
     * @var string
     *
     * @ORM\Column(name="program", type="string", length=255, nullable=true)
     */
    private $program;

    /**
     * @var string
     *
     * @ORM\Column(name="ugaid", type="string", length=255, nullable=true)
     */
    private $ugaid;


    /**
     * @var string
     *
     * @ORM\Column(name="level", type="string", length=255, nullable=true)
     */
    private $level;


    /**
     * @var string
     *
     * @ORM\Column(name="degree", type="string", length=255, nullable=true)
     */
    private $degree;

    /**
     * @var string
     *
     * @ORM\Column(name="institution", type="string", length=255, nullable=true)
     */
    private $institution;

    /**
     * @var string
     *
     * @ORM\Column(name="graddate", type="string", length=255, nullable=true)
     */
    private $graddate;


    /**
     * @var string
     *
     * @ORM\Column(name="gradterm", type="string", length=255, nullable=true)
     */
    private $gradterm;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="cityst", type="string", length=255, nullable=true)
     */
    private $cityst;


    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=255, nullable=true)
     */
    private $country;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=255, nullable=true)
     */
    private $phone;


    /**
     * @var string
     *
     * @ORM\Column(name="area", type="array", length=255, nullable=true)
     */
    private $area;

    /**
     * @var string
     *
     * @ORM\Column(name="interest", type="text", nullable=true)
     */
    private $interest;

    /**
     * @var string
     *
     * @ORM\Column(name="experience", type="text", nullable=true)
     */
    private $experience;

    /**
     * @var string
     *
     * @ORM\Column(name="goals", type="text", nullable=true)
     */
    private $goals;

    /**
     * @var string
     *
     * @ORM\Column(name="notes", type="text", nullable=true)
     */
    private $notes;


    /**
     * @ORM\OneToOne(targetEntity="User", inversedBy="program")
     */
    private $user;



    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set school
     *
     * @param string $school
     *
     * @return Program
     */
    public function setSchool($school)
    {
        $this->school = $school;

        return $this;
    }

    /**
     * Get school
     *
     * @return string
     */
    public function getSchool()
    {
        return $this->school;
    }

    /**
     * Set program
     *
     * @param string $program
     *
     * @return Program
     */
    public function setProgram($program)
    {
        $this->program = $program;

        return $this;
    }

    /**
     * Get program
     *
     * @return string
     */
    public function getProgram()
    {
        return $this->program;
    }

    /**
     * Set ugaid
     *
     * @param string $ugaid
     *
     * @return Program
     */
    public function setUgaid($ugaid)
    {
        $this->ugaid = $ugaid;

        return $this;
    }

    /**
     * Get ugaid
     *
     * @return string
     */
    public function getUgaid()
    {
        return $this->ugaid;
    }

    /**
     * Set level
     *
     * @param string $level
     *
     * @return Program
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return string
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set degree
     *
     * @param string $degree
     *
     * @return Program
     */
    public function setDegree($degree)
    {
        $this->degree = $degree;

        return $this;
    }

    /**
     * Get degree
     *
     * @return string
     */
    public function getDegree()
    {
        return $this->degree;
    }

    /**
     * Set institution
     *
     * @param string $institution
     *
     * @return Program
     */
    public function setInstitution($institution)
    {
        $this->institution = $institution;

        return $this;
    }

    /**
     * Get institution
     *
     * @return string
     */
    public function getInstitution()
    {
        return $this->institution;
    }

    /**
     * Set graddate
     *
     * @param string $graddate
     *
     * @return Program
     */
    public function setGraddate($graddate)
    {
        $this->graddate = $graddate;

        return $this;
    }

    /**
     * Get graddate
     *
     * @return string
     */
    public function getGraddate()
    {
        return $this->graddate;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return Program
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set cityst
     *
     * @param string $cityst
     *
     * @return Program
     */
    public function setCityst($cityst)
    {
        $this->cityst = $cityst;

        return $this;
    }

    /**
     * Get cityst
     *
     * @return string
     */
    public function getCityst()
    {
        return $this->cityst;
    }

    /**
     * Set country
     *
     * @param string $country
     *
     * @return Program
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return Program
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }


    /**
     * Set experience
     *
     * @param string $experience
     *
     * @return Program
     */
    public function setExperience($experience)
    {
        $this->experience = $experience;

        return $this;
    }

    /**
     * Get experience
     *
     * @return string
     */
    public function getExperience()
    {
        return $this->experience;
    }

    /**
     * Set goals
     *
     * @param string $goals
     *
     * @return Program
     */
    public function setGoals($goals)
    {
        $this->goals = $goals;

        return $this;
    }

    /**
     * Get goals
     *
     * @return string
     */
    public function getGoals()
    {
        return $this->goals;
    }

    /**
     * Set notes
     *
     * @param string $notes
     *
     * @return Program
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;

        return $this;
    }

    /**
     * Get notes
     *
     * @return string
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Program
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }



    /**
     * Set area
     *
     * @param array $area
     *
     * @return Program
     */
    public function setArea($area)
    {
        $this->area = $area;

        return $this;
    }

    /**
     * Get area
     *
     * @return array
     */
    public function getArea()
    {
        return $this->area;
    }

    /**
     * Set interest
     *
     * @param string $interest
     *
     * @return Program
     */
    public function setInterest($interest)
    {
        $this->interest = $interest;

        return $this;
    }

    /**
     * Get interest
     *
     * @return string
     */
    public function getInterest()
    {
        return $this->interest;
    }

    /**
     * Set gradterm
     *
     * @param string $gradterm
     *
     * @return Program
     */
    public function setGradterm($gradterm)
    {
        $this->gradterm = $gradterm;

        return $this;
    }

    /**
     * Get gradterm
     *
     * @return string
     */
    public function getGradterm()
    {
        return $this->gradterm;
    }
}
