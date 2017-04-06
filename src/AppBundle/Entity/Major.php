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
     * @ORM\OneToMany(targetEntity="Program", mappedBy="major1" )
     */
    protected $program1;

    /**
     * @ORM\OneToMany(targetEntity="Program", mappedBy="major2" )
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
     * @return Major
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
     * @return Major
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
}
