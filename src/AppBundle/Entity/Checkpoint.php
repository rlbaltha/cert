<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Checkpoint
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\CheckpointRepository")
 */
class Checkpoint
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
    private $name='First Checkpoint';

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255, nullable=true)
     */
    private $type='NA';

    /**
     * @var string
     *
     * @ORM\Column(name="timeframe", type="string", length=255)
     */
    private $timeframe='Current';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="deadline", type="datetime", nullable=true)
     */
    private $deadline;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255)
     */
    private $status='Opened';

    /**
     * @ORM\ManyToOne(targetEntity="Project", inversedBy="checkpoints")
     */
    protected $project;

    /**
     * @ORM\ManyToMany(targetEntity="User", inversedBy="checkpoints")
     */
    protected $reviewers;

    /**
     * @ORM\OneToMany(targetEntity="Review", mappedBy="checkpoint")
     */
    protected $reviews;

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
     * @return Checkpoint
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
     * @return Checkpoint
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
     * @return Checkpoint
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
     * Set timeframe
     *
     * @param string $timeframe
     *
     * @return Checkpoint
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
     * Set deadline
     *
     * @param \DateTime $deadline
     *
     * @return Checkpoint
     */
    public function setDeadline($deadline)
    {
        $this->deadline = $deadline;

        return $this;
    }

    /**
     * Get deadline
     *
     * @return \DateTime
     */
    public function getDeadline()
    {
        return $this->deadline;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return Checkpoint
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
     * Constructor
     */
    public function __construct()
    {
        $this->reviewers = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set project
     *
     * @param \AppBundle\Entity\Project $project
     *
     * @return Checkpoint
     */
    public function setProject(\AppBundle\Entity\Project $project = null)
    {
        $this->project = $project;

        return $this;
    }

    /**
     * Get project
     *
     * @return \AppBundle\Entity\Project
     */
    public function getProject()
    {
        return $this->project;
    }



    /**
     * Add reviewer
     *
     * @param \AppBundle\Entity\User $reviewer
     *
     * @return Checkpoint
     */
    public function addReviewer(\AppBundle\Entity\User $reviewer)
    {
        $this->reviewers[] = $reviewer;

        return $this;
    }

    /**
     * Remove reviewer
     *
     * @param \AppBundle\Entity\User $reviewer
     */
    public function removeReviewer(\AppBundle\Entity\User $reviewer)
    {
        $this->reviewers->removeElement($reviewer);
    }

    /**
     * Get reviewers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getReviewers()
    {
        return $this->reviewers;
    }

    /**
     * Add review
     *
     * @param \AppBundle\Entity\Review $review
     *
     * @return Checkpoint
     */
    public function addReview(\AppBundle\Entity\Review $review)
    {
        $this->reviews[] = $review;

        return $this;
    }

    /**
     * Remove review
     *
     * @param \AppBundle\Entity\Review $review
     */
    public function removeReview(\AppBundle\Entity\Review $review)
    {
        $this->reviews->removeElement($review);
    }

    /**
     * Get reviews
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getReviews()
    {
        return $this->reviews;
    }
}
