<?php

namespace UkronicBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Beloved
 *
 * @ORM\Table(name="beloved")
 * @ORM\Entity(repositoryClass="UkronicBundle\Repository\BelovedRepository")
 */
class Beloved
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
     * @ORM\ManyToOne(targetEntity="User", inversedBy="likes")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="Decrypt", inversedBy="likes")
     * @ORM\JoinColumn(name="decrypt_id", referencedColumnName="id")
     */
    private $decrypt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_like", type="datetime")
     */
    private $dateLike;




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
     * Set dateLike
     *
     * @param \DateTime $dateLike
     *
     * @return Beloved
     */
    public function setDateLike($dateLike)
    {
        $this->dateLike = $dateLike;

        return $this;
    }

    /**
     * Get dateLike
     *
     * @return \DateTime
     */
    public function getDateLike()
    {
        return $this->dateLike;
    }

    /**
     * Set user
     *
     * @param \UkronicBundle\Entity\User $user
     *
     * @return Beloved
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

    /**
     * Set decrypt
     *
     * @param \UkronicBundle\Entity\Decrypt $decrypt
     *
     * @return Beloved
     */
    public function setDecrypt(\UkronicBundle\Entity\Decrypt $decrypt = null)
    {
        $this->decrypt = $decrypt;

        return $this;
    }

    /**
     * Get decrypt
     *
     * @return \UkronicBundle\Entity\Decrypt
     */
    public function getDecrypt()
    {
        return $this->decrypt;
    }
}
