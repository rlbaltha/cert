<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * School
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\SchoolRepository")
 */
class School
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
     * @ORM\OneToMany(targetEntity="Program", mappedBy="school1" )
     */
    protected $program1;

    /**
     * @ORM\OneToMany(targetEntity="Program", mappedBy="school2" )
     */
    protected $program2;

    /**
     * @ORM\OneToMany(targetEntity="Course", mappedBy="school" )
     */
    protected $courses;

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
     * @return School
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
     * Constructor
     */
    public function __construct()
    {
        $this->program1 = new \Doctrine\Common\Collections\ArrayCollection();
        $this->program2 = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add program1
     *
     * @param \AppBundle\Entity\Program $program1
     *
     * @return School
     */
    public function addProgram1(\AppBundle\Entity\Program $program1)
    {
        $this->program1[] = $program1;

        return $this;
    }

    /**
     * Remove program1
     *
     * @param \AppBundle\Entity\Program $program1
     */
    public function removeProgram1(\AppBundle\Entity\Program $program1)
    {
        $this->program1->removeElement($program1);
    }

    /**
     * Get program1
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProgram1()
    {
        return $this->program1;
    }

    /**
     * Add program2
     *
     * @param \AppBundle\Entity\Program $program2
     *
     * @return School
     */
    public function addProgram2(\AppBundle\Entity\Program $program2)
    {
        $this->program2[] = $program2;

        return $this;
    }

    /**
     * Remove program2
     *
     * @param \AppBundle\Entity\Program $program2
     */
    public function removeProgram2(\AppBundle\Entity\Program $program2)
    {
        $this->program2->removeElement($program2);
    }

    /**
     * Get program2
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProgram2()
    {
        return $this->program2;
    }

    /**
     * Add course
     *
     * @param \AppBundle\Entity\Course $course
     *
     * @return School
     */
    public function addCourse(\AppBundle\Entity\Course $course)
    {
        $this->courses[] = $course;

        return $this;
    }

    /**
     * Remove course
     *
     * @param \AppBundle\Entity\Course $course
     */
    public function removeCourse(\AppBundle\Entity\Course $course)
    {
        $this->courses->removeElement($course);
    }

    /**
     * Get courses
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCourses()
    {
        return $this->courses;
    }
}
