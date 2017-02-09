<?php

namespace UkronicBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Comment
 *
 * @ORM\Table(name="comment")
 * @ORM\Entity(repositoryClass="UkronicBundle\Repository\CommentRepository")
 */
class Comment
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
     * @ORM\ManyToOne(targetEntity="User", inversedBy="comments")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="Decrypt", inversedBy="comments")
     * @ORM\JoinColumn(name="decrypt_id", referencedColumnName="id")
     */
    private $decrypt;

    /**
     * @ORM\OneToMany(targetEntity="LikeComment", mappedBy="comment")
     */
    private $commentLikes;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_comment", type="datetime")
     */
    private $dateComment;

     public function __construct()
    {
        $this->likeComments = new ArrayCollection();
    }


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
     * @return Comment
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
     * Set dateComment
     *
     * @param \DateTime $dateComment
     *
     * @return Comment
     */
    public function setDateComment($dateComment)
    {
        $this->dateComment = $dateComment;

        return $this;
    }

    /**
     * Get dateComment
     *
     * @return \DateTime
     */
    public function getDateComment()
    {
        return $this->dateComment;
    }

    /**
     * Set user
     *
     * @param \UkronicBundle\Entity\User $user
     *
     * @return Comment
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
     * @return Comment
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

    /**
     * Add commentLike
     *
     * @param \UkronicBundle\Entity\LikeComment $commentLike
     *
     * @return Comment
     */
    public function addCommentLike(\UkronicBundle\Entity\LikeComment $commentLike)
    {
        $this->commentLikes[] = $commentLike;

        return $this;
    }

    /**
     * Remove commentLike
     *
     * @param \UkronicBundle\Entity\LikeComment $commentLike
     */
    public function removeCommentLike(\UkronicBundle\Entity\LikeComment $commentLike)
    {
        $this->commentLikes->removeElement($commentLike);
    }

    /**
     * Get commentLikes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCommentLikes()
    {
        return $this->commentLikes;
    }
}
