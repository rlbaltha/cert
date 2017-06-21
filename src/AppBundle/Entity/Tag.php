<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tag
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\TagRepository")
 */
class Tag
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
     * @ORM\Column(name="color", type="string", length=255)
     */
    private $color;

    /**
     * @var int
     *
     * @ORM\Column(name="sortorder", type="integer")
     */
    private $sortorder;

    /**
     * @ORM\ManyToMany(targetEntity="Idea", mappedBy="tags")
     */
    protected $ideas;

    /**
     * @ORM\ManyToMany(targetEntity="Capstone", mappedBy="tags")
     */
    protected $capstones;

    /**
     * @ORM\ManyToMany(targetEntity="Source", mappedBy="tags")
     */
    protected $sources;

    /**
     * @ORM\OneToMany(targetEntity="Tag", mappedBy="top")
     */
    private $subs;

    /**
     * @ORM\ManyToOne(targetEntity="Tag", inversedBy="subs")
     * @ORM\JoinColumn(onDelete="SET NULL")
     *  @ORM\OrderBy({"sortorder" = "DESC"})
     */
    private $top;

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
     * @return Tag
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
     * Set color
     *
     * @param string $color
     *
     * @return Tag
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->ideas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->sources = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add idea
     *
     * @param \AppBundle\Entity\Idea $idea
     *
     * @return Tag
     */
    public function addIdea(\AppBundle\Entity\Idea $idea)
    {
        $this->ideas[] = $idea;

        return $this;
    }

    /**
     * Remove idea
     *
     * @param \AppBundle\Entity\Idea $idea
     */
    public function removeIdea(\AppBundle\Entity\Idea $idea)
    {
        $this->ideas->removeElement($idea);
    }

    /**
     * Get ideas
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIdeas()
    {
        return $this->ideas;
    }

    /**
     * Add source
     *
     * @param \AppBundle\Entity\Source $source
     *
     * @return Tag
     */
    public function addSource(\AppBundle\Entity\Source $source)
    {
        $this->sources[] = $source;

        return $this;
    }

    /**
     * Remove source
     *
     * @param \AppBundle\Entity\Source $source
     */
    public function removeSource(\AppBundle\Entity\Source $source)
    {
        $this->sources->removeElement($source);
    }

    /**
     * Get sources
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSources()
    {
        return $this->sources;
    }

    /**
     * Add sub
     *
     * @param \AppBundle\Entity\Tag $sub
     *
     * @return Tag
     */
    public function addSub(\AppBundle\Entity\Tag $sub)
    {
        $this->subs[] = $sub;

        return $this;
    }

    /**
     * Remove sub
     *
     * @param \AppBundle\Entity\Tag $sub
     */
    public function removeSub(\AppBundle\Entity\Tag $sub)
    {
        $this->subs->removeElement($sub);
    }

    /**
     * Get subs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSubs()
    {
        return $this->subs;
    }

    /**
     * Set top
     *
     * @param \AppBundle\Entity\Tag $top
     *
     * @return Tag
     */
    public function setTop(\AppBundle\Entity\Tag $top = null)
    {
        $this->top = $top;

        return $this;
    }

    /**
     * Get top
     *
     * @return \AppBundle\Entity\Tag
     */
    public function getTop()
    {
        return $this->top;
    }

    /**
     * Add capstone
     *
     * @param \AppBundle\Entity\Capstone $capstone
     *
     * @return Tag
     */
    public function addCapstone(\AppBundle\Entity\Capstone $capstone)
    {
        $this->capstones[] = $capstone;

        return $this;
    }

    /**
     * Remove capstone
     *
     * @param \AppBundle\Entity\Capstone $capstone
     */
    public function removeCapstone(\AppBundle\Entity\Capstone $capstone)
    {
        $this->capstones->removeElement($capstone);
    }

    /**
     * Get capstones
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCapstones()
    {
        return $this->capstones;
    }


    /**
     * Set sortorder
     *
     * @param integer $sortorder
     *
     * @return Tag
     */
    public function setSortorder($sortorder)
    {
        $this->sortorder = $sortorder;

        return $this;
    }

    /**
     * Get sortorder
     *
     * @return integer
     */
    public function getSortorder()
    {
        return $this->sortorder;
    }
}
