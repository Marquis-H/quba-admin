<?php

namespace CommonBundle\Entity;

/**
 * IdleMessage
 */
class IdleMessage
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var bool
     */
    private $isReply = true;

    /**
     * @var string|null
     */
    private $buyComment;

    /**
     * @var string|null
     */
    private $saleComment;

    /**
     * @var \DateTime|null
     */
    private $buyCommentAt;

    /**
     * @var \DateTime|null
     */
    private $saleCommentAt;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @var \CommonBundle\Entity\IdleApplication
     */
    private $IdleApplication;

    /**
     * @var \CommonBundle\Entity\WeappUserProfile
     */
    private $BuyProfile;

    /**
     * @var \CommonBundle\Entity\WeappUserProfile
     */
    private $SaleProfile;


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
     * Set isReply.
     *
     * @param bool $isReply
     *
     * @return IdleMessage
     */
    public function setIsReply($isReply)
    {
        $this->isReply = $isReply;

        return $this;
    }

    /**
     * Get isReply.
     *
     * @return bool
     */
    public function getIsReply()
    {
        return $this->isReply;
    }

    /**
     * Set buyComment.
     *
     * @param string|null $buyComment
     *
     * @return IdleMessage
     */
    public function setBuyComment($buyComment = null)
    {
        $this->buyComment = $buyComment;

        return $this;
    }

    /**
     * Get buyComment.
     *
     * @return string|null
     */
    public function getBuyComment()
    {
        return $this->buyComment;
    }

    /**
     * Set saleComment.
     *
     * @param string|null $saleComment
     *
     * @return IdleMessage
     */
    public function setSaleComment($saleComment = null)
    {
        $this->saleComment = $saleComment;

        return $this;
    }

    /**
     * Get saleComment.
     *
     * @return string|null
     */
    public function getSaleComment()
    {
        return $this->saleComment;
    }

    /**
     * Set buyCommentAt.
     *
     * @param \DateTime|null $buyCommentAt
     *
     * @return IdleMessage
     */
    public function setBuyCommentAt($buyCommentAt = null)
    {
        $this->buyCommentAt = $buyCommentAt;

        return $this;
    }

    /**
     * Get buyCommentAt.
     *
     * @return \DateTime|null
     */
    public function getBuyCommentAt()
    {
        return $this->buyCommentAt;
    }

    /**
     * Set saleCommentAt.
     *
     * @param \DateTime|null $saleCommentAt
     *
     * @return IdleMessage
     */
    public function setSaleCommentAt($saleCommentAt = null)
    {
        $this->saleCommentAt = $saleCommentAt;

        return $this;
    }

    /**
     * Get saleCommentAt.
     *
     * @return \DateTime|null
     */
    public function getSaleCommentAt()
    {
        return $this->saleCommentAt;
    }

    /**
     * Set createdAt.
     *
     * @param \DateTime $createdAt
     *
     * @return IdleMessage
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
     * @return IdleMessage
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
     * Set idleApplication.
     *
     * @param \CommonBundle\Entity\IdleApplication|null $idleApplication
     *
     * @return IdleMessage
     */
    public function setIdleApplication(\CommonBundle\Entity\IdleApplication $idleApplication = null)
    {
        $this->IdleApplication = $idleApplication;

        return $this;
    }

    /**
     * Get idleApplication.
     *
     * @return \CommonBundle\Entity\IdleApplication|null
     */
    public function getIdleApplication()
    {
        return $this->IdleApplication;
    }

    /**
     * Set buyProfile.
     *
     * @param \CommonBundle\Entity\WeappUserProfile|null $buyProfile
     *
     * @return IdleMessage
     */
    public function setBuyProfile(\CommonBundle\Entity\WeappUserProfile $buyProfile = null)
    {
        $this->BuyProfile = $buyProfile;

        return $this;
    }

    /**
     * Get buyProfile.
     *
     * @return \CommonBundle\Entity\WeappUserProfile|null
     */
    public function getBuyProfile()
    {
        return $this->BuyProfile;
    }

    /**
     * Set saleProfile.
     *
     * @param \CommonBundle\Entity\WeappUserProfile|null $saleProfile
     *
     * @return IdleMessage
     */
    public function setSaleProfile(\CommonBundle\Entity\WeappUserProfile $saleProfile = null)
    {
        $this->SaleProfile = $saleProfile;

        return $this;
    }

    /**
     * Get saleProfile.
     *
     * @return \CommonBundle\Entity\WeappUserProfile|null
     */
    public function getSaleProfile()
    {
        return $this->SaleProfile;
    }
}
