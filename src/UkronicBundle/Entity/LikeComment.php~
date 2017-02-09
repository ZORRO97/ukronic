<?php

namespace UkronicBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LikeComment
 *
 * @ORM\Table(name="like_comment")
 * @ORM\Entity(repositoryClass="UkronicBundle\Repository\LikeCommentRepository")
 */
class LikeComment
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
     * @ORM\ManyToOne(targetEntity="User", inversedBy="commentLikes")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="Comment", inversedBy="commentLikes")
     * @ORM\JoinColumn(name="comment_id", referencedColumnName="id")
     */
    private $comment;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateLikeComment", type="datetime")
     */
    private $dateLikeComment;


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
     * Set dateLikeComment
     *
     * @param \DateTime $dateLikeComment
     *
     * @return LikeComment
     */
    public function setDateLikeComment($dateLikeComment)
    {
        $this->dateLikeComment = $dateLikeComment;

        return $this;
    }

    /**
     * Get dateLikeComment
     *
     * @return \DateTime
     */
    public function getDateLikeComment()
    {
        return $this->dateLikeComment;
    }

    /**
     * Set user
     *
     * @param \UkronicBundle\Entity\User $user
     *
     * @return LikeComment
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
     * Set comment
     *
     * @param \UkronicBundle\Entity\Comment $comment
     *
     * @return LikeComment
     */
    public function setComment(\UkronicBundle\Entity\Comment $comment = null)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return \UkronicBundle\Entity\Comment
     */
    public function getComment()
    {
        return $this->comment;
    }
}
