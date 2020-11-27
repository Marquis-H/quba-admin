<?php

namespace CommonBundle\Entity;

/**
 * Topic
 */
class Topic
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $content;

    /**
     * @var string
     */
    private $category;

    /**
     * @var int
     */
    private $views = 0;

    /**
     * @var int
     */
    private $like = 0;

    /**
     * @var bool
     */
    private $isEnable = true;

    /**
     * @var array
     */
    private $photos = [];

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $TopicComment;

    /**
     * @var \CommonBundle\Entity\WeappUserProfile
     */
    private $Publisher;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->TopicComment = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set title.
     *
     * @param string $title
     *
     * @return Topic
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set content.
     *
     * @param string $content
     *
     * @return Topic
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content.
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set category.
     *
     * @param string $category
     *
     * @return Topic
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category.
     *
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set views.
     *
     * @param int $views
     *
     * @return Topic
     */
    public function setViews($views)
    {
        $this->views = $views;

        return $this;
    }

    /**
     * Get views.
     *
     * @return int
     */
    public function getViews()
    {
        return $this->views;
    }

    /**
     * Set like.
     *
     * @param int $like
     *
     * @return Topic
     */
    public function setLike($like)
    {
        $this->like = $like;

        return $this;
    }

    /**
     * Get like.
     *
     * @return int
     */
    public function getLike()
    {
        return $this->like;
    }

    /**
     * Set isEnable.
     *
     * @param bool $isEnable
     *
     * @return Topic
     */
    public function setIsEnable($isEnable)
    {
        $this->isEnable = $isEnable;

        return $this;
    }

    /**
     * Get isEnable.
     *
     * @return bool
     */
    public function getIsEnable()
    {
        return $this->isEnable;
    }

    /**
     * Set photos.
     *
     * @param array $photos
     *
     * @return Topic
     */
    public function setPhotos($photos)
    {
        $this->photos = $photos;

        return $this;
    }

    /**
     * Get photos.
     *
     * @return array
     */
    public function getPhotos()
    {
        return $this->photos;
    }

    /**
     * Set createdAt.
     *
     * @param \DateTime $createdAt
     *
     * @return Topic
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
     * Set updatedAt.
     *
     * @param \DateTime $updatedAt
     *
     * @return Topic
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt.
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Add topicComment.
     *
     * @param \CommonBundle\Entity\TopicComment $topicComment
     *
     * @return Topic
     */
    public function addTopicComment(\CommonBundle\Entity\TopicComment $topicComment)
    {
        $this->TopicComment[] = $topicComment;

        return $this;
    }

    /**
     * Remove topicComment.
     *
     * @param \CommonBundle\Entity\TopicComment $topicComment
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeTopicComment(\CommonBundle\Entity\TopicComment $topicComment)
    {
        return $this->TopicComment->removeElement($topicComment);
    }

    /**
     * Get topicComment.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTopicComment()
    {
        return $this->TopicComment;
    }

    /**
     * Set publisher.
     *
     * @param \CommonBundle\Entity\WeappUserProfile|null $publisher
     *
     * @return Topic
     */
    public function setPublisher(\CommonBundle\Entity\WeappUserProfile $publisher = null)
    {
        $this->Publisher = $publisher;

        return $this;
    }

    /**
     * Get publisher.
     *
     * @return \CommonBundle\Entity\WeappUserProfile|null
     */
    public function getPublisher()
    {
        return $this->Publisher;
    }
}
