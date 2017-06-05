<?php
/*
id
username
username_canonical
email
email_canonical
enabled
salt
password
last_login
locked
expired
expires_at
confirmation_token
password_requested_at
roles
credentials_expired
credentials_expire_at
lastname
firstname
ugaid
*/
namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\Collection;

/**
 * User
 *
 * @ORM\Table(name="cert_user")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="lastname", type="string", length=255, nullable=true)
     */
    private $lastname;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="firstname", type="string", length=255, nullable=true)
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255, nullable=true)
     */
    private $status='Account Created';

    /**
     * @var string
     *
     * @ORM\Column(name="notes", type="text", nullable=true)
     */
    private $notes;

    /**
     * @ORM\OneToOne(targetEntity="Program", mappedBy="user")
     */
    private $program;

    /**
     * @ORM\OneToOne(targetEntity="Checklist", mappedBy="user")
     */
    private $checklist;

    /**
     * @ORM\OneToOne(targetEntity="Capstone", mappedBy="user")
     */
    private $capstone;

    /**
     * @ORM\OneToMany(targetEntity="Responseset", mappedBy="user")
     */
    private $responsesets;

    /**
     * @ORM\OneToMany(targetEntity="Project", mappedBy="user")
     */
    private $projects;

    /**
     * @ORM\OneToMany(targetEntity="Review", mappedBy="reviewer")
     */
    private $reviews;

    /**
     * @ORM\ManyToMany(targetEntity="Checkpoint", mappedBy="reviewers")
     */
    protected $checkpoints;

    /**
     * @ORM\ManyToOne(targetEntity="Status")
     */
    protected $progress;

    /**
     * @var \DateTime $created
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $created;


    /**
     * @var \DateTime $contentChanged
     *
     * @ORM\Column(type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="change", field={"notes"})
     */
    private $notesChanged;

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
     * Set lastname
     *
     * @param string $lastname
     *
     * @return User
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     *
     * @return User
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }



    /**
     * Set program
     *
     * @param \AppBundle\Entity\Program $program
     *
     * @return User
     */
    public function setProgram(\AppBundle\Entity\Program $program = null)
    {
        $this->program = $program;

        return $this;
    }

    /**
     * Get program
     *
     * @return \AppBundle\Entity\Program
     */
    public function getProgram()
    {
        return $this->program;
    }

    /**
     * Set checklist
     *
     * @param \AppBundle\Entity\Checklist $checklist
     *
     * @return User
     */
    public function setChecklist(\AppBundle\Entity\Checklist $checklist = null)
    {
        $this->checklist = $checklist;

        return $this;
    }

    /**
     * Get checklist
     *
     * @return \AppBundle\Entity\Checklist
     */
    public function getChecklist()
    {
        return $this->checklist;
    }

    /**
     * Set capstone
     *
     * @param \AppBundle\Entity\Capstone $capstone
     *
     * @return User
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

    /**
     * Set status
     *
     * @param string $status
     *
     * @return User
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
     * Set notes
     *
     * @param string $notes
     *
     * @return User
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
     * Set created
     *
     * @param \DateTime $created
     *
     * @return User
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
     * Set notesChanged
     *
     * @param \DateTime $notesChanged
     *
     * @return User
     */
    public function setNotesChanged($notesChanged)
    {
        $this->notesChanged = $notesChanged;

        return $this;
    }

    /**
     * Get notesChanged
     *
     * @return \DateTime
     */
    public function getNotesChanged()
    {
        return $this->notesChanged;
    }


    /**
     * Set progress
     *
     * @param \AppBundle\Entity\Status $progress
     *
     * @return User
     */
    public function setProgress(\AppBundle\Entity\Status $progress = null)
    {
        $this->progress = $progress;

        return $this;
    }

    /**
     * Get progress
     *
     * @return \AppBundle\Entity\Status
     */
    public function getProgress()
    {
        return $this->progress;
    }

    /**
     * Add responseset
     *
     * @param \AppBundle\Entity\Responseset $responseset
     *
     * @return User
     */
    public function addResponseset(\AppBundle\Entity\Responseset $responseset)
    {
        $this->responsesets[] = $responseset;

        return $this;
    }

    /**
     * Remove responseset
     *
     * @param \AppBundle\Entity\Responseset $responseset
     */
    public function removeResponseset(\AppBundle\Entity\Responseset $responseset)
    {
        $this->responsesets->removeElement($responseset);
    }

    /**
     * Get responsesets
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getResponsesets()
    {
        return $this->responsesets;
    }


    /**
     * Add project
     *
     * @param \AppBundle\Entity\Project $project
     *
     * @return User
     */
    public function addProject(\AppBundle\Entity\Project $project)
    {
        $this->projects[] = $project;

        return $this;
    }

    /**
     * Remove project
     *
     * @param \AppBundle\Entity\Project $project
     */
    public function removeProject(\AppBundle\Entity\Project $project)
    {
        $this->projects->removeElement($project);
    }

    /**
     * Get projects
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProjects()
    {
        return $this->projects;
    }



    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        $name = $this->getFirstname().' '.$this->getLastname();
        return $name;
    }



    /**
     * Add checkpoint
     *
     * @param \AppBundle\Entity\Checkpoint $checkpoint
     *
     * @return User
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
     * Add review
     *
     * @param \AppBundle\Entity\Review $review
     *
     * @return User
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
