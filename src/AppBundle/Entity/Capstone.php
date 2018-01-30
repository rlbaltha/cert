<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Capstone
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\CapstoneRepository")
 */
class Capstone
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
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="goals", type="text", nullable=true)
     */
    private $goals;

    /**
     * @var string
     *
     * @ORM\Column(name="objectives", type="text", nullable=true)
     */
    private $objectives;


    /**
     * @var string
     *
     * @ORM\Column(name="timeline", type="text", nullable=true)
     */
    private $timeline;


    /**
     * @var string
     *
     * @ORM\Column(name="partners", type="text", nullable=true)
     */
    private $partners;

    /**
     * @var string
     *
     * @ORM\Column(name="funding", type="text", nullable=true)
     */
    private $funding;

    /**
     * @var string
     *
     * @ORM\Column(name="completion", type="text", nullable=true)
     */
    private $completion;

    /**
     * @var string
     *
     * @ORM\Column(name="repeatable", type="string", length=255, nullable=true)
     */
    private $repeatable='Yes';

    /**
     * @var string
     *
     * @ORM\Column(name="repeatinfo", type="text", nullable=true)
     */
    private $repeatinfo;

    /**
     * @var string
     *
     * @ORM\Column(name="personal_objectives", type="text", nullable=true)
     */
    private $personal_objectives;

    /**
     * @var string
     *
     * @ORM\Column(name="success_metrics", type="text", nullable=true)
     */
    private $success_metrics;

    /**
     * @var string
     *
     * @ORM\Column(name="steps", type="text", nullable=true)
     */
    private $steps;

    /**
     * @var string
     *
     * @ORM\Column(name="application", type="text", nullable=true)
     */
    private $application;

    /**
     * @var string
     *
     * @ORM\Column(name="mentor", type="string", length=255, nullable=true)
     */
    private $mentor;

    /**
     * @var string
     *
     * @ORM\Column(name="mentor_email", type="string", length=255, nullable=true)
     */
    private $mentor_email;

    /**
     * @var string
     *
     * @ORM\Column(name="mentor_expectations", type="text",  nullable=true)
     */
    private $mentor_expectations;

    /**
     * @var string
     *
     * @ORM\Column(name="group_project", type="string", length=255, nullable=true)
     */
    private $group_project='No';

    /**
     * @var string
     *
     * @ORM\Column(name="group_members", type="text",  nullable=true)
     */
    private $group_members;

    /**
     * @var string
     *
     * @ORM\Column(name="timeframe", type="string", length=255, nullable=true)
     */
    private $timeframe;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255, nullable=true)
     */
    private $status='Created';

    /**
     * @ORM\OneToOne(targetEntity="User", inversedBy="capstone")
     */
    private $user;

    /**
     * @ORM\OneToOne(targetEntity="Project", mappedBy="capstone")
     */
    private $project;

    /**
     * @ORM\OneToMany(targetEntity="Responseset", mappedBy="capstone")
     */
    private $responsesets;

    /**
     * @ORM\ManyToMany(targetEntity="User", inversedBy="capstone_mentees")
     */
    private $capstone_mentor;

    /**
     * @ORM\ManyToMany(targetEntity="Tag", inversedBy="capstones")
     */
    protected $tags;

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
     * Set title
     *
     * @param string $title
     *
     * @return Capstone
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
     * Set type
     *
     * @param string $type
     *
     * @return Capstone
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
     * Set description
     *
     * @param string $description
     *
     * @return Capstone
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
     * Set steps
     *
     * @param string $steps
     *
     * @return Capstone
     */
    public function setSteps($steps)
    {
        $this->steps = $steps;

        return $this;
    }

    /**
     * Get steps
     *
     * @return string
     */
    public function getSteps()
    {
        return $this->steps;
    }

    /**
     * Set application
     *
     * @param string $application
     *
     * @return Capstone
     */
    public function setApplication($application)
    {
        $this->application = $application;

        return $this;
    }

    /**
     * Get application
     *
     * @return string
     */
    public function getApplication()
    {
        return $this->application;
    }

    /**
     * Set mentor
     *
     * @param string $mentor
     *
     * @return Capstone
     */
    public function setMentor($mentor)
    {
        $this->mentor = $mentor;

        return $this;
    }

    /**
     * Get mentor
     *
     * @return string
     */
    public function getMentor()
    {
        return $this->mentor;
    }

    /**
     * Set timeframe
     *
     * @param string $timeframe
     *
     * @return Capstone
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
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Capstone
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
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Capstone
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
     * @return Capstone
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
     * Set goals
     *
     * @param string $goals
     *
     * @return Capstone
     */
    public function setGoals($goals)
    {
        $this->goals = $goals;

        return $this;
    }

    /**
     * Get goals
     *
     * @return string
     */
    public function getGoals()
    {
        return $this->goals;
    }

    /**
     * Set objectives
     *
     * @param string $objectives
     *
     * @return Capstone
     */
    public function setObjectives($objectives)
    {
        $this->objectives = $objectives;

        return $this;
    }

    /**
     * Get objectives
     *
     * @return string
     */
    public function getObjectives()
    {
        return $this->objectives;
    }

    /**
     * Set timeline
     *
     * @param string $timeline
     *
     * @return Capstone
     */
    public function setTimeline($timeline)
    {
        $this->timeline = $timeline;

        return $this;
    }

    /**
     * Get timeline
     *
     * @return string
     */
    public function getTimeline()
    {
        return $this->timeline;
    }

    /**
     * Set partners
     *
     * @param string $partners
     *
     * @return Capstone
     */
    public function setPartners($partners)
    {
        $this->partners = $partners;

        return $this;
    }

    /**
     * Get partners
     *
     * @return string
     */
    public function getPartners()
    {
        return $this->partners;
    }

    /**
     * Set personalObjectives
     *
     * @param string $personalObjectives
     *
     * @return Capstone
     */
    public function setPersonalObjectives($personalObjectives)
    {
        $this->personal_objectives = $personalObjectives;

        return $this;
    }

    /**
     * Get personalObjectives
     *
     * @return string
     */
    public function getPersonalObjectives()
    {
        return $this->personal_objectives;
    }

    /**
     * Set successMetrics
     *
     * @param string $successMetrics
     *
     * @return Capstone
     */
    public function setSuccessMetrics($successMetrics)
    {
        $this->success_metrics = $successMetrics;

        return $this;
    }

    /**
     * Get successMetrics
     *
     * @return string
     */
    public function getSuccessMetrics()
    {
        return $this->success_metrics;
    }

    /**
     * Set mentorEmail
     *
     * @param string $mentorEmail
     *
     * @return Capstone
     */
    public function setMentorEmail($mentorEmail)
    {
        $this->mentor_email = $mentorEmail;

        return $this;
    }

    /**
     * Get mentorEmail
     *
     * @return string
     */
    public function getMentorEmail()
    {
        return $this->mentor_email;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return Capstone
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
     * Set groupMembers
     *
     * @param string $groupMembers
     *
     * @return Capstone
     */
    public function setGroupMembers($groupMembers)
    {
        $this->group_members = $groupMembers;

        return $this;
    }

    /**
     * Get groupMembers
     *
     * @return string
     */
    public function getGroupMembers()
    {
        return $this->group_members;
    }

    /**
     * Set groupProject
     *
     * @param string $groupProject
     *
     * @return Capstone
     */
    public function setGroupProject($groupProject)
    {
        $this->group_project = $groupProject;

        return $this;
    }

    /**
     * Get groupProject
     *
     * @return string
     */
    public function getGroupProject()
    {
        return $this->group_project;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->responsesets = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add responseset
     *
     * @param \AppBundle\Entity\Responseset $responseset
     *
     * @return Capstone
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
     * Add tag
     *
     * @param \AppBundle\Entity\Tag $tag
     *
     * @return Capstone
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


    

    /**
     * Set project
     *
     * @param \AppBundle\Entity\Project $project
     *
     * @return Capstone
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
     * Set funding
     *
     * @param string $funding
     *
     * @return Capstone
     */
    public function setFunding($funding)
    {
        $this->funding = $funding;

        return $this;
    }

    /**
     * Get funding
     *
     * @return string
     */
    public function getFunding()
    {
        return $this->funding;
    }

    /**
     * Set completion
     *
     * @param string $completion
     *
     * @return Capstone
     */
    public function setCompletion($completion)
    {
        $this->completion = $completion;

        return $this;
    }

    /**
     * Get completion
     *
     * @return string
     */
    public function getCompletion()
    {
        return $this->completion;
    }

    /**
     * Set repeatable
     *
     * @param string $repeatable
     *
     * @return Capstone
     */
    public function setRepeatable($repeatable)
    {
        $this->repeatable = $repeatable;

        return $this;
    }

    /**
     * Get repeatable
     *
     * @return string
     */
    public function getRepeatable()
    {
        return $this->repeatable;
    }


    /**
     * Set mentorExpectations
     *
     * @param string $mentorExpectations
     *
     * @return Capstone
     */
    public function setMentorExpectations($mentorExpectations)
    {
        $this->mentor_expectations = $mentorExpectations;

        return $this;
    }

    /**
     * Get mentorExpectations
     *
     * @return string
     */
    public function getMentorExpectations()
    {
        return $this->mentor_expectations;
    }
    

    /**
     * Set repeatinfo
     *
     * @param string $repeatinfo
     *
     * @return Capstone
     */
    public function setRepeatinfo($repeatinfo)
    {
        $this->repeatinfo = $repeatinfo;

        return $this;
    }

    /**
     * Get repeatinfo
     *
     * @return string
     */
    public function getRepeatinfo()
    {
        return $this->repeatinfo;
    }

    /**
     * Add capstoneMentor
     *
     * @param \AppBundle\Entity\User $capstoneMentor
     *
     * @return Capstone
     */
    public function addCapstoneMentor(\AppBundle\Entity\User $capstoneMentor)
    {
        $this->capstone_mentor[] = $capstoneMentor;

        return $this;
    }

    /**
     * Remove capstoneMentor
     *
     * @param \AppBundle\Entity\User $capstoneMentor
     */
    public function removeCapstoneMentor(\AppBundle\Entity\User $capstoneMentor)
    {
        $this->capstone_mentor->removeElement($capstoneMentor);
    }

    /**
     * Get capstoneMentor
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCapstoneMentor()
    {
        return $this->capstone_mentor;
    }
}
