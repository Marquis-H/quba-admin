<?php

namespace CommonBundle\Entity;

/**
 * TopicComment
 */
class TopicComment
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
     * @var int
     */
    private $level;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $Childrens;

    /**
     * @var \CommonBundle\Entity\Topic
     */
    private $Topic;

    /**
     * @var \CommonBundle\Entity\WeappUserProfile
     */
    private $Profile;

    /**
     * @var \CommonBundle\Entity\TopicComment
     */
    private $Parent;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->Childrens = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * @return TopicComment
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
     * Set level.
     *
     * @param int $level
     *
     * @return TopicComment
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level.
     *
     * @return int
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set createdAt.
     *
     * @param \DateTime $createdAt
     *
     * @return TopicComment
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
     * Add children.
     *
     * @param \CommonBundle\Entity\TopicComment $children
     *
     * @return TopicComment
     */
    public function addChildren(\CommonBundle\Entity\TopicComment $children)
    {
        $this->Childrens[] = $children;

        return $this;
    }

    /**
     * Remove children.
     *
     * @param \CommonBundle\Entity\TopicComment $children
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeChildren(\CommonBundle\Entity\TopicComment $children)
    {
        return $this->Childrens->removeElement($children);
    }

    /**
     * Get childrens.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChildrens()
    {
        return $this->Childrens;
    }

    /**
     * Set topic.
     *
     * @param \CommonBundle\Entity\Topic|null $topic
     *
     * @return TopicComment
     */
    public function setTopic(\CommonBundle\Entity\Topic $topic = null)
    {
        $this->Topic = $topic;

        return $this;
    }

    /**
     * Get topic.
     *
     * @return \CommonBundle\Entity\Topic|null
     */
    public function getTopic()
    {
        return $this->Topic;
    }

    /**
     * Set profile.
     *
     * @param \CommonBundle\Entity\WeappUserProfile|null $profile
     *
     * @return TopicComment
     */
    public function setProfile(\CommonBundle\Entity\WeappUserProfile $profile = null)
    {
        $this->Profile = $profile;

        return $this;
    }

    /**
     * Get profile.
     *
     * @return \CommonBundle\Entity\WeappUserProfile|null
     */
    public function getProfile()
    {
        return $this->Profile;
    }

    /**
     * Set parent.
     *
     * @param \CommonBundle\Entity\TopicComment|null $parent
     *
     * @return TopicComment
     */
    public function setParent(\CommonBundle\Entity\TopicComment $parent = null)
    {
        $this->Parent = $parent;

        return $this;
    }

    /**
     * Get parent.
     *
     * @return \CommonBundle\Entity\TopicComment|null
     */
    public function getParent()
    {
        return $this->Parent;
    }
}
