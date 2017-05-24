<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Review
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\ReviewRepository")
 */
class Review
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
     * @ORM\Column(name="status", type="string", length=255)
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="body", type="text")
     */
    private $body;

    /**
     * @ORM\ManyToOne(targetEntity="Checkpoint", inversedBy="reviews")
     */
    protected $checkpoint;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="reviews")
     */
    protected $reviewer;

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
     * Set status
     *
     * @param string $status
     *
     * @return Review
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
     * Set body
     *
     * @param string $body
     *
     * @return Review
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get body
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set checkpoint
     *
     * @param \AppBundle\Entity\Checkpoint $checkpoint
     *
     * @return Review
     */
    public function setCheckpoint(\AppBundle\Entity\Checkpoint $checkpoint = null)
    {
        $this->checkpoint = $checkpoint;

        return $this;
    }

    /**
     * Get checkpoint
     *
     * @return \AppBundle\Entity\Checkpoint
     */
    public function getCheckpoint()
    {
        return $this->checkpoint;
    }

    /**
     * Set reviewer
     *
     * @param \AppBundle\Entity\User $reviewer
     *
     * @return Review
     */
    public function setReviewer(\AppBundle\Entity\User $reviewer = null)
    {
        $this->reviewer = $reviewer;

        return $this;
    }

    /**
     * Get reviewer
     *
     * @return \AppBundle\Entity\User
     */
    public function getReviewer()
    {
        return $this->reviewer;
    }
}
