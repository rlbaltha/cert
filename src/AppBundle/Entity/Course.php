<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Course
 *
 * @ORM\Table(name="course")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\CourseRepository")
 */
class Course
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
     * @ORM\Column(name="prefix", type="string", length=255, nullable=true)
     */
    private $prefix;

    /**
     * @var string
     *
     * @ORM\Column(name="crosslisting", type="string", length=255, nullable=true)
     */
    private $crosslisting;

    /**
     * @var string
     *
     * @ORM\Column(name="coursenumber", type="string", length=255, nullable=true)
     */
    private $coursenumber;

    /**
     * @var string
     *
     * @ORM\Column(name="split", type="string", length=255, nullable=true)
     */
    private $split;

    /**
     * @var string
     *
     * @ORM\Column(name="post", type="string", length=255, nullable=true)
     */
    private $post;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="offered", type="string", length=255, nullable=true)
     */
    private $offered;

    /**
     * @var string
     *
     * @ORM\Column(name="prereqs", type="string", length=255, nullable=true)
     */
    private $prereqs;

    /**
     * @var string
     *
     * @ORM\Column(name="instructor", type="string", length=255, nullable=true)
     */
    private $instructor;


    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="syllabus", type="text", nullable=true)
     */
    private $syllabus='Needed';

    /**
     * @var string
     *
     * @ORM\Column(name="notes", type="text", nullable=true)
     */
    private $notes;

    /**
     * @var string
     *
     * @ORM\Column(name="contact", type="string", length=255)
     */
    private $contact='Needed';

    /**
     * @var string
     *
     * @ORM\Column(name="contact_email", type="string", length=255, nullable=true)
     */
    private $contact_email='Needed';

    /**
     * @var string
     *
     * @ORM\Column(name="pillar", type="string", length=255, nullable=true)
     */
    private $pillar;


    /**
     * @ORM\ManyToOne(targetEntity="School", inversedBy="courses")
     */
    private $school;

    /**
     * @var string
     *
     * @ORM\Column(name="level", type="string", length=255, nullable=true)
     */
    private $level='Undergrad';

    /**
     * @var string
     *
     * @ORM\Column(name="location", type="string", length=255, nullable=true)
     */
    private $location='Campus';

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255, nullable=true)
     */
    private $status='pending';

    /**
     * @ORM\OneToMany(targetEntity="Upload", mappedBy="course")
     */
    protected $uploads;


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
     * @return Course
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
     * @return Course
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
     * Set pillar
     *
     * @param string $pillar
     *
     * @return Course
     */
    public function setPillar($pillar)
    {
        $this->pillar = $pillar;

        return $this;
    }

    /**
     * Get pillar
     *
     * @return string
     */
    public function getPillar()
    {
        return $this->pillar;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Course
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
     * Set offered
     *
     * @param string $offered
     *
     * @return Course
     */
    public function setOffered($offered)
    {
        $this->offered = $offered;

        return $this;
    }

    /**
     * Get offered
     *
     * @return string
     */
    public function getOffered()
    {
        return $this->offered;
    }

    /**
     * Set prereqs
     *
     * @param string $prereqs
     *
     * @return Course
     */
    public function setPrereqs($prereqs)
    {
        $this->prereqs = $prereqs;

        return $this;
    }

    /**
     * Get prereqs
     *
     * @return string
     */
    public function getPrereqs()
    {
        return $this->prereqs;
    }

    /**
     * Set instructor
     *
     * @param string $instructor
     *
     * @return Course
     */
    public function setInstructor($instructor)
    {
        $this->instructor = $instructor;

        return $this;
    }

    /**
     * Get instructor
     *
     * @return string
     */
    public function getInstructor()
    {
        return $this->instructor;
    }



    /**
     * Set level
     *
     * @param string $level
     *
     * @return Course
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }


    /**
     * Set status
     *
     * @param string $status
     *
     * @return Course
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
     * Set syllabus
     *
     * @param string $syllabus
     *
     * @return Course
     */
    public function setSyllabus($syllabus)
    {
        $this->syllabus = $syllabus;

        return $this;
    }

    /**
     * Get syllabus
     *
     * @return string
     */
    public function getSyllabus()
    {
        return $this->syllabus;
    }

    /**
     * Set contact
     *
     * @param string $contact
     *
     * @return Course
     */
    public function setContact($contact)
    {
        $this->contact = $contact;

        return $this;
    }

    /**
     * Get contact
     *
     * @return string
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * Set location
     *
     * @param string $location
     *
     * @return Course
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location
     *
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }



    /**
     * Set notes
     *
     * @param string $notes
     *
     * @return Course
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;

        return $this;
    }

    /**
     * Get notes
     *
     * @return string
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * Set contactEmail
     *
     * @param string $contactEmail
     *
     * @return Course
     */
    public function setContactEmail($contactEmail)
    {
        $this->contact_email = $contactEmail;

        return $this;
    }

    /**
     * Get contactEmail
     *
     * @return string
     */
    public function getContactEmail()
    {
        return $this->contact_email;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->uploads = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add upload
     *
     * @param \AppBundle\Entity\Upload $upload
     *
     * @return Course
     */
    public function addUpload(\AppBundle\Entity\Upload $upload)
    {
        $this->uploads[] = $upload;

        return $this;
    }

    /**
     * Remove upload
     *
     * @param \AppBundle\Entity\Upload $upload
     */
    public function removeUpload(\AppBundle\Entity\Upload $upload)
    {
        $this->uploads->removeElement($upload);
    }

    /**
     * Get uploads
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUploads()
    {
        return $this->uploads;
    }


    /**
     * Get level
     *
     * @return string
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set school
     *
     * @param \AppBundle\Entity\School $school
     *
     * @return Course
     */
    public function setSchool(\AppBundle\Entity\School $school = null)
    {
        $this->school = $school;

        return $this;
    }

    /**
     * Get school
     *
     * @return \AppBundle\Entity\School
     */
    public function getSchool()
    {
        return $this->school;
    }
    

    /**
     * Set split
     *
     * @param string $split
     *
     * @return Course
     */
    public function setSplit($split)
    {
        $this->split = $split;

        return $this;
    }

    /**
     * Get split
     *
     * @return string
     */
    public function getSplit()
    {
        return $this->split;
    }

    /**
     * Set post
     *
     * @param string $post
     *
     * @return Course
     */
    public function setPost($post)
    {
        $this->post = $post;

        return $this;
    }

    /**
     * Get post
     *
     * @return string
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * Set prefix
     *
     * @param string $prefix
     *
     * @return Course
     */
    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;

        return $this;
    }

    /**
     * Get prefix
     *
     * @return string
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * Set coursenumber
     *
     * @param string $coursenumber
     *
     * @return Course
     */
    public function setCoursenumber($coursenumber)
    {
        $this->coursenumber = $coursenumber;

        return $this;
    }

    /**
     * Get coursenumber
     *
     * @return string
     */
    public function getCoursenumber()
    {
        return $this->coursenumber;
    }

    /**
     * Set crosslisting
     *
     * @param string $crosslisting
     *
     * @return Course
     */
    public function setCrosslisting($crosslisting)
    {
        $this->crosslisting = $crosslisting;

        return $this;
    }

    /**
     * Get crosslisting
     *
     * @return string
     */
    public function getCrosslisting()
    {
        return $this->crosslisting;
    }
}
