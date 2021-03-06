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
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type = 'resource';

    /**
     * @var int
     *
     * @ORM\Column(name="sortorder", type="integer")
     */
    private $sortorder;


    /**
     * @ORM\ManyToMany(targetEntity="Capstone", mappedBy="tags")
     */
    protected $capstones;


    /**
     * @ORM\ManyToMany(targetEntity="Faculty", mappedBy="tags")
     */
    protected $faculty;

    /**
     * @ORM\ManyToMany(targetEntity="Notification", mappedBy="tags")
     */
    protected $notifications;

    /**
     * @ORM\ManyToMany(targetEntity="User", mappedBy="tags")
     */
    protected $users;

    /**
     * @ORM\OneToMany(targetEntity="Tag", mappedBy="top")
     * @ORM\OrderBy({"sortorder" = "ASC"})
     */
    private $subs;

    /**
     * @ORM\ManyToOne(targetEntity="Tag", inversedBy="subs")
     * @ORM\JoinColumn(onDelete="SET NULL")
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
        $this->sources = new \Doctrine\Common\Collections\ArrayCollection();
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


    /**
     * Add faculty
     *
     * @param \AppBundle\Entity\Faculty $faculty
     *
     * @return Tag
     */
    public function addFaculty(\AppBundle\Entity\Faculty $faculty)
    {
        $this->faculty[] = $faculty;

        return $this;
    }

    /**
     * Remove faculty
     *
     * @param \AppBundle\Entity\Faculty $faculty
     */
    public function removeFaculty(\AppBundle\Entity\Faculty $faculty)
    {
        $this->faculty->removeElement($faculty);
    }

    /**
     * Get faculty
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFaculty()
    {
        return $this->faculty;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Tag
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
     * Add user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Tag
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
     * Add notification
     *
     * @param \AppBundle\Entity\Notification $notification
     *
     * @return Tag
     */
    public function addNotification(\AppBundle\Entity\Notification $notification)
    {
        $this->notifications[] = $notification;

        return $this;
    }

    /**
     * Remove notification
     *
     * @param \AppBundle\Entity\Notification $notification
     */
    public function removeNotification(\AppBundle\Entity\Notification $notification)
    {
        $this->notifications->removeElement($notification);
    }

    /**
     * Get notifications
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getNotifications()
    {
        return $this->notifications;
    }
}
