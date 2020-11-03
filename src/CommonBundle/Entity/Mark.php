<?php

namespace CommonBundle\Entity;

/**
 * Mark
 */
class Mark
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $slug;

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
    private $WeappUserProfile;

    /**
     * @var \CommonBundle\Entity\IdleApplication
     */
    private $IdleApplication;

    /**
     * @var \CommonBundle\Entity\MatchInfo
     */
    private $MatchInfo;


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
     * Set slug.
     *
     * @param string $slug
     *
     * @return Mark
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug.
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set createdAt.
     *
     * @param \DateTime $createdAt
     *
     * @return Mark
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
     * @return Mark
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
     * Set weappUserProfile.
     *
     * @param \CommonBundle\Entity\WeappUserProfile|null $weappUserProfile
     *
     * @return Mark
     */
    public function setWeappUserProfile(\CommonBundle\Entity\WeappUserProfile $weappUserProfile = null)
    {
        $this->WeappUserProfile = $weappUserProfile;

        return $this;
    }

    /**
     * Get weappUserProfile.
     *
     * @return \CommonBundle\Entity\WeappUserProfile|null
     */
    public function getWeappUserProfile()
    {
        return $this->WeappUserProfile;
    }

    /**
     * Set idleApplication.
     *
     * @param \CommonBundle\Entity\IdleApplication|null $idleApplication
     *
     * @return Mark
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
     * Set matchInfo.
     *
     * @param \CommonBundle\Entity\MatchInfo|null $matchInfo
     *
     * @return Mark
     */
    public function setMatchInfo(\CommonBundle\Entity\MatchInfo $matchInfo = null)
    {
        $this->MatchInfo = $matchInfo;

        return $this;
    }

    /**
     * Get matchInfo.
     *
     * @return \CommonBundle\Entity\MatchInfo|null
     */
    public function getMatchInfo()
    {
        return $this->MatchInfo;
    }
}
