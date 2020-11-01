<?php

namespace CommonBundle\Entity;

/**
 * IdleProfile
 */
class IdleProfile
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $status;

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
     * Set status.
     *
     * @param string $status
     *
     * @return IdleProfile
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status.
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set createdAt.
     *
     * @param \DateTime $createdAt
     *
     * @return IdleProfile
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
     * @return IdleProfile
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
     * @return IdleProfile
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
     * Set profile.
     *
     * @param \CommonBundle\Entity\WeappUserProfile|null $profile
     *
     * @return IdleProfile
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
     * @var \DateTime
     */
    private $tradeAt;

    /**
     * @var \DateTime|null
     */
    private $tradeEndAt;

    /**
     * Set tradeAt.
     *
     * @param \DateTime $tradeAt
     *
     * @return IdleProfile
     */
    public function setTradeAt($tradeAt)
    {
        $this->tradeAt = $tradeAt;

        return $this;
    }

    /**
     * Get tradeAt.
     *
     * @return \DateTime
     */
    public function getTradeAt()
    {
        return $this->tradeAt;
    }

    /**
     * Set tradeEndAt.
     *
     * @param \DateTime|null $tradeEndAt
     *
     * @return IdleProfile
     */
    public function setTradeEndAt($tradeEndAt = null)
    {
        $this->tradeEndAt = $tradeEndAt;

        return $this;
    }

    /**
     * Get tradeEndAt.
     *
     * @return \DateTime|null
     */
    public function getTradeEndAt()
    {
        return $this->tradeEndAt;
    }
    /**
     * @var string
     */
    private $receipt;


    /**
     * Set receipt.
     *
     * @param string $receipt
     *
     * @return IdleProfile
     */
    public function setReceipt($receipt)
    {
        $this->receipt = $receipt;

        return $this;
    }

    /**
     * Get receipt.
     *
     * @return string
     */
    public function getReceipt()
    {
        return $this->receipt;
    }
}
