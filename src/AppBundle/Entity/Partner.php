<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Partner
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\PartnerRepository")
 */
class Partner
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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="purpose", type="text")
     */
    private $purpose;

    /**
     * @var string
     *
     * @ORM\Column(name="background", type="text")
     */
    private $background;

    /**
     * @var string
     *
     * @ORM\Column(name="contribution", type="text")
     */
    private $contribution;

    /**
     * @var string
     *
     * @ORM\Column(name="details", type="text")
     */
    private $details;

    /**
     * @var string
     *
     * @ORM\Column(name="deliverables", type="text")
     */
    private $deliverables;

    /**
     * @var string
     *
     * @ORM\Column(name="outcomes", type="text")
     */
    private $outcomes;

    /**
     * @var string
     *
     * @ORM\Column(name="considerations", type="text")
     */
    private $considerations;

    /**
     * @var string
     *
     * @ORM\Column(name="sources", type="text")
     */
    private $sources;

    /**
     * @var string
     *
     * @ORM\Column(name="qualifications", type="text")
     */
    private $qualifications;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255)
     */
    private $status="pending";

    /**
     * @ORM\ManyToMany(targetEntity="Tag", inversedBy="partners")
     */
    protected $tags;

    /**
     * @ORM\ManyToMany(targetEntity="User", inversedBy="partners")
     */
    private $users;

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
     * Set title
     *
     * @param string $title
     *
     * @return Partner
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
     * Set purpose
     *
     * @param string $purpose
     *
     * @return Partner
     */
    public function setPurpose($purpose)
    {
        $this->purpose = $purpose;

        return $this;
    }

    /**
     * Get purpose
     *
     * @return string
     */
    public function getPurpose()
    {
        return $this->purpose;
    }

    /**
     * Set background
     *
     * @param string $background
     *
     * @return Partner
     */
    public function setBackground($background)
    {
        $this->background = $background;

        return $this;
    }

    /**
     * Get background
     *
     * @return string
     */
    public function getBackground()
    {
        return $this->background;
    }

    /**
     * Set contribution
     *
     * @param string $contribution
     *
     * @return Partner
     */
    public function setContribution($contribution)
    {
        $this->contribution = $contribution;

        return $this;
    }

    /**
     * Get contribution
     *
     * @return string
     */
    public function getContribution()
    {
        return $this->contribution;
    }

    /**
     * Set details
     *
     * @param string $details
     *
     * @return Partner
     */
    public function setDetails($details)
    {
        $this->details = $details;

        return $this;
    }

    /**
     * Get details
     *
     * @return string
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * Set deliverables
     *
     * @param string $deliverables
     *
     * @return Partner
     */
    public function setDeliverables($deliverables)
    {
        $this->deliverables = $deliverables;

        return $this;
    }

    /**
     * Get deliverables
     *
     * @return string
     */
    public function getDeliverables()
    {
        return $this->deliverables;
    }

    /**
     * Set outcomes
     *
     * @param string $outcomes
     *
     * @return Partner
     */
    public function setOutcomes($outcomes)
    {
        $this->outcomes = $outcomes;

        return $this;
    }

    /**
     * Get outcomes
     *
     * @return string
     */
    public function getOutcomes()
    {
        return $this->outcomes;
    }

    /**
     * Set considerations
     *
     * @param string $considerations
     *
     * @return Partner
     */
    public function setConsiderations($considerations)
    {
        $this->considerations = $considerations;

        return $this;
    }

    /**
     * Get considerations
     *
     * @return string
     */
    public function getConsiderations()
    {
        return $this->considerations;
    }

    /**
     * Set sources
     *
     * @param string $sources
     *
     * @return Partner
     */
    public function setSources($sources)
    {
        $this->sources = $sources;

        return $this;
    }

    /**
     * Get sources
     *
     * @return string
     */
    public function getSources()
    {
        return $this->sources;
    }

    /**
     * Set qualifications
     *
     * @param string $qualifications
     *
     * @return Partner
     */
    public function setQualifications($qualifications)
    {
        $this->qualifications = $qualifications;

        return $this;
    }

    /**
     * Get qualifications
     *
     * @return string
     */
    public function getQualifications()
    {
        return $this->qualifications;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
    }



    /**
     * Add user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Partner
     */
    public function addUser(\AppBundle\Entity\User $user)
    {
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \AppBundle\Entity\User $user
     */
    public function removeUser(\AppBundle\Entity\User $user)
    {
        $this->users->removeElement($user);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return Partner
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
     * Add tag
     *
     * @param \AppBundle\Entity\Tag $tag
     *
     * @return Partner
     */
    public function addTag(\AppBundle\Entity\Tag $tag)
    {
        $this->tags[] = $tag;

        return $this;
    }

    /**
     * Remove tag
     *
     * @param \AppBundle\Entity\Tag $tag
     */
    public function removeTag(\AppBundle\Entity\Tag $tag)
    {
        $this->tags->removeElement($tag);
    }

    /**
     * Get tags
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTags()
    {
        return $this->tags;
    }
}
