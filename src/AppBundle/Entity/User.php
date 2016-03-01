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

    public function __construct()
    {
        parent::__construct();
        // your own logic
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
}
