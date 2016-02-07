<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Section
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\SectionRepository")
 */
class Section
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
     * @ORM\Column(name="header", type="text", nullable=true)
     */
    private $header;

    /**
     * @var string
     *
     * @ORM\Column(name="masthead", type="string", length=255, nullable=true)
     */
    private $masthead;

    /**
     * @ORM\Column(type="boolean", name="on_nav", options={"default": false})
     */
    protected $on_nav;

    /**
     * @ORM\OneToMany(targetEntity="Page", mappedBy="section")
     * @ORM\OrderBy({"sortorder" = "ASC"})
     */
    protected $pages;


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
     * @return Section
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
     * Set header
     *
     * @param string $header
     *
     * @return Section
     */
    public function setHeader($header)
    {
        $this->header = $header;

        return $this;
    }

    /**
     * Get header
     *
     * @return string
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * Set masthead
     *
     * @param string $masthead
     *
     * @return Section
     */
    public function setMasthead($masthead)
    {
        $this->masthead = $masthead;

        return $this;
    }

    /**
     * Get masthead
     *
     * @return string
     */
    public function getMasthead()
    {
        return $this->masthead;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->pages = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add page
     *
     * @param \AppBundle\Entity\Page $page
     *
     * @return Section
     */
    public function addPage(\AppBundle\Entity\Page $page)
    {
        $this->pages[] = $page;

        return $this;
    }

    /**
     * Remove page
     *
     * @param \AppBundle\Entity\Page $page
     */
    public function removePage(\AppBundle\Entity\Page $page)
    {
        $this->pages->removeElement($page);
    }

    /**
     * Get pages
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPages()
    {
        return $this->pages;
    }


    /**
     * Set onNav
     *
     * @param boolean $onNav
     *
     * @return Section
     */
    public function setOnNav($onNav)
    {
        $this->on_nav = $onNav;

        return $this;
    }

    /**
     * Get onNav
     *
     * @return boolean
     */
    public function getOnNav()
    {
        return $this->on_nav;
    }
}
