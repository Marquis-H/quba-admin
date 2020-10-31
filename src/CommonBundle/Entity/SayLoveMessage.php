<?php

namespace CommonBundle\Entity;

/**
 * SayLoveMessage
 */
class SayLoveMessage
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $selfName;

    /**
     * @var string
     */
    private $selfNickname;

    /**
     * @var string
     */
    private $selfGender;

    /**
     * @var string
     */
    private $sheName;

    /**
     * @var string
     */
    private $sheGender;

    /**
     * @var string
     */
    private $content;

    /**
     * @var int
     */
    private $likeNum = 0;

    /**
     * @var int
     */
    private $guess = 0;

    /**
     * @var int
     */
    private $guessRight = 0;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @var \CommonBundle\Entity\WeappUserProfile
     */
    private $Profile;


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
     * Set selfName.
     *
     * @param string $selfName
     *
     * @return SayLoveMessage
     */
    public function setSelfName($selfName)
    {
        $this->selfName = $selfName;

        return $this;
    }

    /**
     * Get selfName.
     *
     * @return string
     */
    public function getSelfName()
    {
        return $this->selfName;
    }

    /**
     * Set selfNickname.
     *
     * @param string $selfNickname
     *
     * @return SayLoveMessage
     */
    public function setSelfNickname($selfNickname)
    {
        $this->selfNickname = $selfNickname;

        return $this;
    }

    /**
     * Get selfNickname.
     *
     * @return string
     */
    public function getSelfNickname()
    {
        return $this->selfNickname;
    }

    /**
     * Set selfGender.
     *
     * @param string $selfGender
     *
     * @return SayLoveMessage
     */
    public function setSelfGender($selfGender)
    {
        $this->selfGender = $selfGender;

        return $this;
    }

    /**
     * Get selfGender.
     *
     * @return string
     */
    public function getSelfGender()
    {
        return $this->selfGender;
    }

    /**
     * Set sheName.
     *
     * @param string $sheName
     *
     * @return SayLoveMessage
     */
    public function setSheName($sheName)
    {
        $this->sheName = $sheName;

        return $this;
    }

    /**
     * Get sheName.
     *
     * @return string
     */
    public function getSheName()
    {
        return $this->sheName;
    }

    /**
     * Set sheGender.
     *
     * @param string $sheGender
     *
     * @return SayLoveMessage
     */
    public function setSheGender($sheGender)
    {
        $this->sheGender = $sheGender;

        return $this;
    }

    /**
     * Get sheGender.
     *
     * @return string
     */
    public function getSheGender()
    {
        return $this->sheGender;
    }

    /**
     * Set content.
     *
     * @param string $content
     *
     * @return SayLoveMessage
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
     * Set like.
     *
     * @param int $like
     *
     * @return SayLoveMessage
     */
    public function setLike($like)
    {
        $this->likeNum = $like;

        return $this;
    }

    /**
     * Get like.
     *
     * @return int
     */
    public function getLike()
    {
        return $this->likeNum;
    }

    /**
     * Set guess.
     *
     * @param int $guess
     *
     * @return SayLoveMessage
     */
    public function setGuess($guess)
    {
        $this->guess = $guess;

        return $this;
    }

    /**
     * Get guess.
     *
     * @return int
     */
    public function getGuess()
    {
        return $this->guess;
    }

    /**
     * Set guessRight.
     *
     * @param int $guessRight
     *
     * @return SayLoveMessage
     */
    public function setGuessRight($guessRight)
    {
        $this->guessRight = $guessRight;

        return $this;
    }

    /**
     * Get guessRight.
     *
     * @return int
     */
    public function getGuessRight()
    {
        return $this->guessRight;
    }

    /**
     * Set createdAt.
     *
     * @param \DateTime $createdAt
     *
     * @return SayLoveMessage
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
     * @return SayLoveMessage
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
     * Set profile.
     *
     * @param \CommonBundle\Entity\WeappUserProfile|null $profile
     *
     * @return SayLoveMessage
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
     * @var \Doctrine\Common\Collections\Collection
     */
    private $SayLoveMessageComment;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->SayLoveMessageComment = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set likeNum.
     *
     * @param int $likeNum
     *
     * @return SayLoveMessage
     */
    public function setLikeNum($likeNum)
    {
        $this->likeNum = $likeNum;

        return $this;
    }

    /**
     * Get likeNum.
     *
     * @return int
     */
    public function getLikeNum()
    {
        return $this->likeNum;
    }

    /**
     * Add sayLoveMessageComment.
     *
     * @param \CommonBundle\Entity\SayLoveMessageComment $sayLoveMessageComment
     *
     * @return SayLoveMessage
     */
    public function addSayLoveMessageComment(\CommonBundle\Entity\SayLoveMessageComment $sayLoveMessageComment)
    {
        $this->SayLoveMessageComment[] = $sayLoveMessageComment;

        return $this;
    }

    /**
     * Remove sayLoveMessageComment.
     *
     * @param \CommonBundle\Entity\SayLoveMessageComment $sayLoveMessageComment
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeSayLoveMessageComment(\CommonBundle\Entity\SayLoveMessageComment $sayLoveMessageComment)
    {
        return $this->SayLoveMessageComment->removeElement($sayLoveMessageComment);
    }

    /**
     * Get sayLoveMessageComment.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSayLoveMessageComment()
    {
        return $this->SayLoveMessageComment;
    }
}
