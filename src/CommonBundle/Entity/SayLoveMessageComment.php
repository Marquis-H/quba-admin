<?php

namespace CommonBundle\Entity;

/**
 * SayLoveMessageComment
 */
class SayLoveMessageComment
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $comment;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \CommonBundle\Entity\SayLoveMessage
     */
    private $SayLoveMessage;


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set comment.
     *
     * @param string $comment
     *
     * @return SayLoveMessageComment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment.
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set createdAt.
     *
     * @param \DateTime $createdAt
     *
     * @return SayLoveMessageComment
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt.
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set sayLoveMessage.
     *
     * @param \CommonBundle\Entity\SayLoveMessage|null $sayLoveMessage
     *
     * @return SayLoveMessageComment
     */
    public function setSayLoveMessage(\CommonBundle\Entity\SayLoveMessage $sayLoveMessage = null)
    {
        $this->SayLoveMessage = $sayLoveMessage;

        return $this;
    }

    /**
     * Get sayLoveMessage.
     *
     * @return \CommonBundle\Entity\SayLoveMessage|null
     */
    public function getSayLoveMessage()
    {
        return $this->SayLoveMessage;
    }
}
