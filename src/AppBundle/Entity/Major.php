<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Major
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\MajorRepository")
 */
class Major
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
     * @ORM\ManyToOne(targetEntity="Program", inversedBy="major1" )
     */
    protected $program1;

    /**
     * @ORM\ManyToOne(targetEntity="Program", inversedBy="major2" )
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
     * @return Major
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
     * @return Major
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
     * @return Major
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