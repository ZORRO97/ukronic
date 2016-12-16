<?php

namespace UkronicBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
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
     * @ORM\OneToMany(targetEntity="Decrypt", mappedBy="user")
     */
    private $decrypts;

    /**
     * @ORM\OneToMany(targetEntity="Rating", mappedBy="user")
     */
    private $ratings;

    /**
     * @ORM\OneToMany(targetEntity="Histo", mappedBy="user")
     */
    private $histos;

    public function __construct()
    {
        parent::__construct();
        // your own logic
        $this->decrypts = new ArrayCollection();
        $this->ratings = new ArrayCollection();
        $this->histos = new ArrayCollection();
    }

    /**
     * Add decrypt
     *
     * @param \UkronicBundle\Entity\Decrypt $decrypt
     *
     * @return User
     */
    public function addDecrypt(\UkronicBundle\Entity\Decrypt $decrypt)
    {
        $this->decrypts[] = $decrypt;


        return $this;
    }

    /**
     * Remove decrypt
     *
     * @param \UkronicBundle\Entity\Decrypt $decrypt
     */
    public function removeDecrypt(\UkronicBundle\Entity\Decrypt $decrypt)
    {
        $this->decrypts->removeElement($decrypt);
    }

    /**
     * Get decrypts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDecrypts()
    {
        return $this->decrypts;
    }

    /**
     * Add rating
     *
     * @param \UkronicBundle\Entity\Rating $rating
     *
     * @return User
     */
    public function addRating(\UkronicBundle\Entity\Rating $rating)
    {
        $this->ratings[] = $rating;

        return $this;
    }

    /**
     * Remove rating
     *
     * @param \UkronicBundle\Entity\Rating $rating
     */
    public function removeRating(\UkronicBundle\Entity\Rating $rating)
    {
        $this->ratings->removeElement($rating);
    }

    /**
     * Get ratings
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRatings()
    {
        return $this->ratings;
    }
}
