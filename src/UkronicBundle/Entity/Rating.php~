<?php

namespace UkronicBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Rating
 *
 * @ORM\Table(name="rating")
 * @ORM\Entity(repositoryClass="UkronicBundle\Repository\RatingRepository")
 */
class Rating
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
     * @ORM\ManyToOne(targetEntity="User", inversedBy="ratings")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="Movie", inversedBy="ratings")
     * @ORM\JoinColumn(name="movie_id", referencedColumnName="id")
     */
    private $movie;

    /**
     * @var int
     *
     * @ORM\Column(name="note", type="integer")
     */
    private $note;

    /**
     * @var int
     *
     * @ORM\Column(name="ambiguous", type="integer")
     */
    private $ambiguous;

    /**
     * @var int
     *
     * @ORM\Column(name="understand", type="integer")
     */
    private $understand;


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
     * Set note
     *
     * @param integer $note
     *
     * @return Rating
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return int
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set ambiguous
     *
     * @param integer $ambiguous
     *
     * @return Rating
     */
    public function setAmbiguous($ambiguous)
    {
        $this->ambiguous = $ambiguous;

        return $this;
    }

    /**
     * Get ambiguous
     *
     * @return int
     */
    public function getAmbiguous()
    {
        return $this->ambiguous;
    }

    /**
     * Set understand
     *
     * @param integer $understand
     *
     * @return Rating
     */
    public function setUnderstand($understand)
    {
        $this->understand = $understand;

        return $this;
    }

    /**
     * Get understand
     *
     * @return int
     */
    public function getUnderstand()
    {
        return $this->understand;
    }

    /**
     * Set user
     *
     * @param \UkronicBundle\Entity\User $user
     *
     * @return Rating
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
     * Set movie
     *
     * @param \UkronicBundle\Entity\Movie $movie
     *
     * @return Rating
     */
    public function setMovie(\UkronicBundle\Entity\Movie $movie = null)
    {
        $this->movie = $movie;

        return $this;
    }

    /**
     * Get movie
     *
     * @return \UkronicBundle\Entity\Movie
     */
    public function getMovie()
    {
        return $this->movie;
    }
}
