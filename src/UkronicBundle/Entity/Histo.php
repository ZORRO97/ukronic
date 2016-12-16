<?php

namespace UkronicBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Histo
 *
 * @ORM\Table(name="histo")
 * @ORM\Entity(repositoryClass="UkronicBundle\Repository\HistoRepository")
 */
class Histo
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="histos")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @var int
     *
     * @ORM\Column(name="action", type="integer")
     */
    private $action;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_action", type="datetime")
     */
    private $dateAction;

    /**
     * @var int
     *
     * @ORM\Column(name="reference", type="integer")
     */
    private $reference;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set action
     *
     * @param integer $action
     *
     * @return Histo
     */
    public function setAction($action)
    {
        $this->action = $action;

        return $this;
    }

    /**
     * Get action
     *
     * @return int
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Set dateAction
     *
     * @param \DateTime $dateAction
     *
     * @return Histo
     */
    public function setDateAction($dateAction)
    {
        $this->dateAction = $dateAction;

        return $this;
    }

    /**
     * Get dateAction
     *
     * @return \DateTime
     */
    public function getDateAction()
    {
        return $this->dateAction;
    }

    /**
     * Set reference
     *
     * @param integer $reference
     *
     * @return Histo
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Get reference
     *
     * @return int
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Set user
     *
     * @param \UkronicBundle\Entity\User $user
     *
     * @return Histo
     */
    public function setUser(\UkronicBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \UkronicBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
