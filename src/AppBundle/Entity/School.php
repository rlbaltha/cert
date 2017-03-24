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
     * @ORM\ManyToOne(targetEntity="Program", inversedBy="school1" )
     */
    protected $program1;

    /**
     * @ORM\ManyToOne(targetEntity="Program", inversedBy="school2" )
     */
    protected $program2;

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
     * Set program1
     *
     * @param \AppBundle\Entity\Program $program1
     *
     * @return School
     */
    public function setProgram1(\AppBundle\Entity\Program $program1 = null)
    {
        $this->program1 = $program1;

        return $this;
    }

    /**
     * Get program1
     *
     * @return \AppBundle\Entity\Program
     */
    public function getProgram1()
    {
        return $this->program1;
    }

    /**
     * Set program2
     *
     * @param \AppBundle\Entity\Program $program2
     *
     * @return School
     */
    public function setProgram2(\AppBundle\Entity\Program $program2 = null)
    {
        $this->program2 = $program2;

        return $this;
    }

    /**
     * Get program2
     *
     * @return \AppBundle\Entity\Program
     */
    public function getProgram2()
    {
        return $this->program2;
    }
}
