<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Response
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\ResponseRepository")
 */
class Response
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
     * @ORM\Column(name="response", type="text", nullable=true)
     */
    private $response;

    /**
     * @ORM\ManyToOne(targetEntity="Responseset", inversedBy="responses" )
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    protected $responseset;


    /**
     * @ORM\ManyToOne(targetEntity="Question", inversedBy="responses")
     */
    private $question;


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
     * Set response
     *
     * @param string $response
     *
     * @return Response
     */
    public function setResponse($response)
    {
        $this->response = $response;

        return $this;
    }

    /**
     * Get response
     *
     * @return string
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * Set responseset
     *
     * @param \AppBundle\Entity\Responseset $responseset
     *
     * @return Response
     */
    public function setResponseset(\AppBundle\Entity\Responseset $responseset = null)
    {
        $this->responseset = $responseset;

        return $this;
    }

    /**
     * Get responseset
     *
     * @return \AppBundle\Entity\Responseset
     */
    public function getResponseset()
    {
        return $this->responseset;
    }

    /**
     * Set question
     *
     * @param \AppBundle\Entity\Question $question
     *
     * @return Response
     */
    public function setQuestion(\AppBundle\Entity\Question $question = null)
    {
        $this->question = $question;

        return $this;
    }

    /**
     * Get question
     *
     * @return \AppBundle\Entity\Question
     */
    public function getQuestion()
    {
        return $this->question;
    }
}
