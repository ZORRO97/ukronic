<?php

namespace UkronicBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Decrypt
 *
 * @ORM\Table(name="decrypt")
 * @ORM\Entity(repositoryClass="UkronicBundle\Repository\DecryptRepository")
 */

class Decrypt

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
     * @ORM\ManyToOne(targetEntity="User", inversedBy="decrypts")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="Movie", inversedBy="decrypts")
     * @ORM\JoinColumn(name="movie_id", referencedColumnName="id")
     */
    private $movie;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_decrypt", type="date")
     */
    private $dateDecrypt;

    /**
     * @var int
     *
     * @ORM\Column(name="nb_read", type="integer")
     */
    private $nbRead;

    /**
     * @var int
     *
     * @ORM\Column(name="nb_liked", type="integer")
     */
    private $nbLiked;

    /**
     * @var int
     *
     * @ORM\Column(name="word_count", type="integer")
     */
    private $wordCount;

    /**
     * @var string
     *
     * @ORM\Column(name="typeDecrypt", type="string", length=1)
     */
    private $typeDecrypt;


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
     * Set content
     *
     * @param string $content
     *
     * @return Decrypt
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set dateDecrypt
     *
     * @param \DateTime $dateDecrypt
     *
     * @return Decrypt
     */
    public function setDateDecrypt($dateDecrypt)
    {
        $this->dateDecrypt = $dateDecrypt;

        return $this;
    }

    /**
     * Get dateDecrypt
     *
     * @return \DateTime
     */
    public function getDateDecrypt()
    {
        return $this->dateDecrypt;
    }

    /**
     * Set nbRead
     *
     * @param integer $nbRead
     *
     * @return Decrypt
     */
    public function setNbRead($nbRead)
    {
        $this->nbRead = $nbRead;

        return $this;
    }

    /**
     * Get nbRead
     *
     * @return int
     */
    public function getNbRead()
    {
        return $this->nbRead;
    }

    /**
     * Set nbLiked
     *
     * @param integer $nbLiked
     *
     * @return Decrypt
     */
    public function setNbLiked($nbLiked)
    {
        $this->nbLiked = $nbLiked;

        return $this;
    }

    /**
     * Get nbLiked
     *
     * @return int
     */
    public function getNbLiked()
    {
        return $this->nbLiked;
    }

    /**
     * Set typeDecrypt
     *
     * @param string $typeDecrypt
     *
     * @return Decrypt
     */
    public function setTypeDecrypt($typeDecrypt)
    {
        $this->typeDecrypt = $typeDecrypt;

        return $this;
    }

    /**
     * Get typeDecrypt
     *
     * @return string
     */
    public function getTypeDecrypt()
    {
        return $this->typeDecrypt;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Decrypt
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
     * Set user
     *
     * @param \UkronicBundle\Entity\User $user
     *
     * @return Decrypt
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
     * @return Decrypt
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

    /**
     * Set wordCount
     *
     * @param integer $wordCount
     *
     * @return Decrypt
     */
    public function setWordCount($wordCount)
    {
        $this->wordCount = $wordCount;

        return $this;
    }

    /**
     * Get wordCount
     *
     * @return integer
     */
    public function getWordCount()
    {
        return $this->wordCount;
    }
}