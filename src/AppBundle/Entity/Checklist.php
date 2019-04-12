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
     * @var string
     *
     * @ORM\Column(name="presentation", type="string", length=255, nullable=true)
     */
    private $presentation="Seminar";

    /**
     * @ORM\OneToOne(targetEntity="User", inversedBy="checklist")
     */
    private $user;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="athena", type="datetime", nullable=true)
     */
    private $athena;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="pre_assess", type="datetime", nullable=true)
     */
    private $pre_assess;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="post_assess", type="datetime", nullable=true)
     */
    private $post_assess;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="orientation", type="datetime", nullable=true)
     */
    private $orientation;

    /**
     * @var string
     *
     * @ORM\Column(name="capstonedate", type="string", length=255, nullable=true)
     */
    private $capstonedate;


    /**
     * @var string
     *
     * @ORM\Column(name="capstoneterm", type="string", length=255, nullable=true)
     */
    private $capstoneterm;

    /**
     * @var string
     *
     * @ORM\Column(name="graddate", type="string", length=255, nullable=true)
     */
    private $graddate;


    /**
     * @var string
     *
     * @ORM\Column(name="gradterm", type="string", length=255, nullable=true)
     */
    private $gradterm;

    /**
     * @var string
     *
     * @ORM\Column(name="appliedtograd", type="text", nullable=true)
     */
    private $appliedtograd='no';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="port_date", type="datetime", nullable=true)
     */
    private $port_date;
    

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
     * @ORM\OneToMany(targetEntity="Substitution", mappedBy="checklist")
     */
    private $substitutions;


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

    /**
     * Set orientation
     *
     * @param \DateTime $orientation
     *
     * @return Checklist
     */
    public function setOrientation($orientation)
    {
        $this->orientation = $orientation;

        return $this;
    }

    /**
     * Get orientation
     *
     * @return \DateTime
     */
    public function getOrientation()
    {
        return $this->orientation;
    }

    /**
     * Set presentation
     *
     * @param string $presentation
     *
     * @return Checklist
     */
    public function setPresentation($presentation)
    {
        $this->presentation = $presentation;

        return $this;
    }

    /**
     * Get presentation
     *
     * @return string
     */
    public function getPresentation()
    {
        return $this->presentation;
    }

    /**
     * Set capstonedate
     *
     * @param string $capstonedate
     *
     * @return Checklist
     */
    public function setCapstonedate($capstonedate)
    {
        $this->capstonedate = $capstonedate;

        return $this;
    }

    /**
     * Get capstonedate
     *
     * @return string
     */
    public function getCapstonedate()
    {
        return $this->capstonedate;
    }

    /**
     * Set capstoneterm
     *
     * @param string $capstoneterm
     *
     * @return Checklist
     */
    public function setCapstoneterm($capstoneterm)
    {
        $this->capstoneterm = $capstoneterm;

        return $this;
    }

    /**
     * Get capstoneterm
     *
     * @return string
     */
    public function getCapstoneterm()
    {
        return $this->capstoneterm;
    }

    /**
     * Set athena
     *
     * @param \DateTime $athena
     *
     * @return Checklist
     */
    public function setAthena($athena)
    {
        $this->athena = $athena;

        return $this;
    }

    /**
     * Get athena
     *
     * @return \DateTime
     */
    public function getAthena()
    {
        return $this->athena;
    }

    /**
     * Set graddate
     *
     * @param string $graddate
     *
     * @return Checklist
     */
    public function setGraddate($graddate)
    {
        $this->graddate = $graddate;

        return $this;
    }

    /**
     * Get graddate
     *
     * @return string
     */
    public function getGraddate()
    {
        return $this->graddate;
    }

    /**
     * Set gradterm
     *
     * @param string $gradterm
     *
     * @return Checklist
     */
    public function setGradterm($gradterm)
    {
        $this->gradterm = $gradterm;

        return $this;
    }

    /**
     * Get gradterm
     *
     * @return string
     */
    public function getGradterm()
    {
        return $this->gradterm;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->exceptions = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add substitution
     *
     * @param \AppBundle\Entity\Substitution $substitution
     *
     * @return Checklist
     */
    public function addSubstitution(\AppBundle\Entity\Substitution $substitution)
    {
        $this->substitutions[] = $substitution;

        return $this;
    }

    /**
     * Remove substitution
     *
     * @param \AppBundle\Entity\Substitution $substitution
     */
    public function removeSubstitution(\AppBundle\Entity\Substitution $substitution)
    {
        $this->substitutions->removeElement($substitution);
    }

    /**
     * Get substitutions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSubstitutions()
    {
        return $this->substitutions;
    }

    /**
     * Set appliedtograd
     *
     * @param string $appliedtograd
     *
     * @return Checklist
     */
    public function setAppliedtograd($appliedtograd)
    {
        $this->appliedtograd = $appliedtograd;

        return $this;
    }

    /**
     * Get appliedtograd
     *
     * @return string
     */
    public function getAppliedtograd()
    {
        return $this->appliedtograd;
    }

    /**
     * Set portDate
     *
     * @param \DateTime $portDate
     *
     * @return Checklist
     */
    public function setPortDate($portDate)
    {
        $this->port_date = $portDate;

        return $this;
    }

    /**
     * Get portDate
     *
     * @return \DateTime
     */
    public function getPortDate()
    {
        return $this->port_date;
    }
}
