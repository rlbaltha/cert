<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Project
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\ProjectRepository")
 */
class Project
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
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="timeframe", type="string", length=255, nullable=true)
     */
    private $timeframe;

    /**
     * @ORM\OneToMany(targetEntity="Checkpoint", mappedBy="project")
     */
    protected $checkpoints;

    /**
     * @ORM\OneToOne(targetEntity="Capstone", inversedBy="project")
     */
    private $capstone;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="projects")
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
     * Set name
     *
     * @param string $name
     *
     * @return Project
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
     * @return Project
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
     * Set type
     *
     * @param string $type
     *
     * @return Project
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->checkpoints = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set timeframe
     *
     * @param string $timeframe
     *
     * @return Project
     */
    public function setTimeframe($timeframe)
    {
        $this->timeframe = $timeframe;

        return $this;
    }

    /**
     * Get timeframe
     *
     * @return string
     */
    public function getTimeframe()
    {
        return $this->timeframe;
    }

    /**
     * Add checkpoint
     *
     * @param \AppBundle\Entity\Checkpoint $checkpoint
     *
     * @return Project
     */
    public function addCheckpoint(\AppBundle\Entity\Checkpoint $checkpoint)
    {
        $this->checkpoints[] = $checkpoint;

        return $this;
    }

    /**
     * Remove checkpoint
     *
     * @param \AppBundle\Entity\Checkpoint $checkpoint
     */
    public function removeCheckpoint(\AppBundle\Entity\Checkpoint $checkpoint)
    {
        $this->checkpoints->removeElement($checkpoint);
    }

    /**
     * Get checkpoints
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCheckpoints()
    {
        return $this->checkpoints;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Project
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
     * Set capstone
     *
     * @param \AppBundle\Entity\Capstone $capstone
     *
     * @return Project
     */
    public function setCapstone(\AppBundle\Entity\Capstone $capstone = null)
    {
        $this->capstone = $capstone;

        return $this;
    }

    /**
     * Get capstone
     *
     * @return \AppBundle\Entity\Capstone
     */
    public function getCapstone()
    {
        return $this->capstone;
    }
}
