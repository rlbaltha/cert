<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Checklist
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\ChecklistRepository")
 */
class Checklist
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
     * @ORM\Column(name="exceptions", type="text", nullable=true)
     */
    private $exceptions;

    /**
     * @var string
     *
     * @ORM\Column(name="portfolio", type="string", length=255, nullable=true)
     */
    private $portfolio;

    /**
     * @ORM\OneToOne(targetEntity="User", inversedBy="checklist")
     */
    private $user;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="pre_assess", type="datetime", nullable=true)
     */
    private $pre_assess;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="ost_assess", type="datetime", nullable=true)
     */
    private $post_assess;

    /**
     * @ORM\ManyToOne(targetEntity="Course")
     */
    protected $anchor;

    /**
     * @ORM\ManyToOne(targetEntity="Course")
     */
    protected $sphere1;

    /**
     * @ORM\ManyToOne(targetEntity="Course")
     */
    protected $sphere2;

    /**
     * @ORM\ManyToOne(targetEntity="Course")
     */
    protected $sphere3;

    /**
     * @ORM\ManyToOne(targetEntity="Course")
     */
    protected $seminar;

    /**
     * @ORM\ManyToOne(targetEntity="Course")
     */
    protected $capstone;

    /**
     * @var \DateTime $created
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @var \DateTime $updated
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private $updated;

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
     * Set exceptions
     *
     * @param string $exceptions
     *
     * @return Checklist
     */
    public function setExceptions($exceptions)
    {
        $this->exceptions = $exceptions;

        return $this;
    }

    /**
     * Get exceptions
     *
     * @return string
     */
    public function getExceptions()
    {
        return $this->exceptions;
    }

    /**
     * Set portfolio
     *
     * @param string $portfolio
     *
     * @return Checklist
     */
    public function setPortfolio($portfolio)
    {
        $this->portfolio = $portfolio;

        return $this;
    }

    /**
     * Get portfolio
     *
     * @return string
     */
    public function getPortfolio()
    {
        return $this->portfolio;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Checklist
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
     * Set anchor
     *
     * @param \AppBundle\Entity\Course $anchor
     *
     * @return Checklist
     */
    public function setAnchor(\AppBundle\Entity\Course $anchor = null)
    {
        $this->anchor = $anchor;

        return $this;
    }

    /**
     * Get anchor
     *
     * @return \AppBundle\Entity\Course
     */
    public function getAnchor()
    {
        return $this->anchor;
    }

    /**
     * Set sphere1
     *
     * @param \AppBundle\Entity\Course $sphere1
     *
     * @return Checklist
     */
    public function setSphere1(\AppBundle\Entity\Course $sphere1 = null)
    {
        $this->sphere1 = $sphere1;

        return $this;
    }

    /**
     * Get sphere1
     *
     * @return \AppBundle\Entity\Course
     */
    public function getSphere1()
    {
        return $this->sphere1;
    }

    /**
     * Set sphere2
     *
     * @param \AppBundle\Entity\Course $sphere2
     *
     * @return Checklist
     */
    public function setSphere2(\AppBundle\Entity\Course $sphere2 = null)
    {
        $this->sphere2 = $sphere2;

        return $this;
    }

    /**
     * Get sphere2
     *
     * @return \AppBundle\Entity\Course
     */
    public function getSphere2()
    {
        return $this->sphere2;
    }

    /**
     * Set sphere3
     *
     * @param \AppBundle\Entity\Course $sphere3
     *
     * @return Checklist
     */
    public function setSphere3(\AppBundle\Entity\Course $sphere3 = null)
    {
        $this->sphere3 = $sphere3;

        return $this;
    }

    /**
     * Get sphere3
     *
     * @return \AppBundle\Entity\Course
     */
    public function getSphere3()
    {
        return $this->sphere3;
    }

    /**
     * Set seminar
     *
     * @param \AppBundle\Entity\Course $seminar
     *
     * @return Checklist
     */
    public function setSeminar(\AppBundle\Entity\Course $seminar = null)
    {
        $this->seminar = $seminar;

        return $this;
    }

    /**
     * Get seminar
     *
     * @return \AppBundle\Entity\Course
     */
    public function getSeminar()
    {
        return $this->seminar;
    }

    /**
     * Set capstone
     *
     * @param \AppBundle\Entity\Course $capstone
     *
     * @return Checklist
     */
    public function setCapstone(\AppBundle\Entity\Course $capstone = null)
    {
        $this->capstone = $capstone;

        return $this;
    }

    /**
     * Get capstone
     *
     * @return \AppBundle\Entity\Course
     */
    public function getCapstone()
    {
        return $this->capstone;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Checklist
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     *
     * @return Checklist
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set preAssess
     *
     * @param \DateTime $preAssess
     *
     * @return Checklist
     */
    public function setPreAssess($preAssess)
    {
        $this->pre_assess = $preAssess;

        return $this;
    }

    /**
     * Get preAssess
     *
     * @return \DateTime
     */
    public function getPreAssess()
    {
        return $this->pre_assess;
    }

    /**
     * Set postAssess
     *
     * @param \DateTime $postAssess
     *
     * @return Checklist
     */
    public function setPostAssess($postAssess)
    {
        $this->post_assess = $postAssess;

        return $this;
    }

    /**
     * Get postAssess
     *
     * @return \DateTime
     */
    public function getPostAssess()
    {
        return $this->post_assess;
    }
}
