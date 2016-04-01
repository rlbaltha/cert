<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Course
 *
 * @ORM\Table(name="course")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\CourseRepository")
 */
class Course
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;


    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="offered", type="string", length=255, nullable=true)
     */
    private $offered;

    /**
     * @var string
     *
     * @ORM\Column(name="prereqs", type="string", length=255, nullable=true)
     */
    private $prereqs;

    /**
     * @var string
     *
     * @ORM\Column(name="instructor", type="string", length=255, nullable=true)
     */
    private $instructor;


    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="syllabus", type="text", nullable=true)
     */
    private $syllabus;

    /**
     * @var string
     *
     * @ORM\Column(name="contact", type="string", length=255)
     */
    private $contact;

    /**
     * @var string
     *
     * @ORM\Column(name="pillar", type="string", length=255, nullable=true)
     */
    private $pillar;

    /**
     * @var string
     *
     * @ORM\Column(name="school", type="string", length=255, nullable=true)
     */
    private $school;

    /**
     * @var string
     *
     * @ORM\Column(name="level", type="string", length=255, nullable=true)
     */
    private $level;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255, nullable=true)
     */
    private $status='pending';

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
     * Set name
     *
     * @param string $name
     *
     * @return Course
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Course
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set pillar
     *
     * @param string $pillar
     *
     * @return Course
     */
    public function setPillar($pillar)
    {
        $this->pillar = $pillar;

        return $this;
    }

    /**
     * Get pillar
     *
     * @return string
     */
    public function getPillar()
    {
        return $this->pillar;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Course
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set offered
     *
     * @param string $offered
     *
     * @return Course
     */
    public function setOffered($offered)
    {
        $this->offered = $offered;

        return $this;
    }

    /**
     * Get offered
     *
     * @return string
     */
    public function getOffered()
    {
        return $this->offered;
    }

    /**
     * Set prereqs
     *
     * @param string $prereqs
     *
     * @return Course
     */
    public function setPrereqs($prereqs)
    {
        $this->prereqs = $prereqs;

        return $this;
    }

    /**
     * Get prereqs
     *
     * @return string
     */
    public function getPrereqs()
    {
        return $this->prereqs;
    }

    /**
     * Set instructor
     *
     * @param string $instructor
     *
     * @return Course
     */
    public function setInstructor($instructor)
    {
        $this->instructor = $instructor;

        return $this;
    }

    /**
     * Get instructor
     *
     * @return string
     */
    public function getInstructor()
    {
        return $this->instructor;
    }



    /**
     * Set level
     *
     * @param string $level
     *
     * @return Course
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
     * Set school
     *
     * @param string $school
     *
     * @return Course
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
     * Set status
     *
     * @param string $status
     *
     * @return Course
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set syllabus
     *
     * @param string $syllabus
     *
     * @return Course
     */
    public function setSyllabus($syllabus)
    {
        $this->syllabus = $syllabus;

        return $this;
    }

    /**
     * Get syllabus
     *
     * @return string
     */
    public function getSyllabus()
    {
        return $this->syllabus;
    }

    /**
     * Set contact
     *
     * @param string $contact
     *
     * @return Course
     */
    public function setContact($contact)
    {
        $this->contact = $contact;

        return $this;
    }

    /**
     * Get contact
     *
     * @return string
     */
    public function getContact()
    {
        return $this->contact;
    }
}
