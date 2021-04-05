<?php

namespace CommonBundle\Entity;

/**
 * MatchApplication
 */
class MatchApplication
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $currentStatus;

    /**
     * @var string
     */
    private $skill;

    /**
     * @var string
     */
    private $experience;

    /**
     * @var int
     */
    private $people = 0;

    /**
     * @var int
     */
    private $totalPeople = 0;

    /**
     * @var \DateTime
     */
    private $joinEndAt;

    /**
     * @var string|null
     */
    private $extra;

    /**
     * @var bool
     */
    private $isSponsor;

    /**
     * @var string
     */
    private $matchExperience;

    /**
     * @var string
     */
    private $contact;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @var \CommonBundle\Entity\MatchInfo
     */
    private $MatchInfo;

    /**
     * @var \CommonBundle\Entity\WeappUserProfile
     */
    private $Profile;

    /**
     * @var bool
     */
    private $isLock = false;

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
     * Set currentStatus.
     *
     * @param string $currentStatus
     *
     * @return MatchApplication
     */
    public function setCurrentStatus($currentStatus)
    {
        $this->currentStatus = $currentStatus;

        return $this;
    }

    /**
     * Get currentStatus.
     *
     * @return string
     */
    public function getCurrentStatus()
    {
        return $this->currentStatus;
    }

    /**
     * Set skill.
     *
     * @param string $skill
     *
     * @return MatchApplication
     */
    public function setSkill($skill)
    {
        $this->skill = $skill;

        return $this;
    }

    /**
     * Get skill.
     *
     * @return string
     */
    public function getSkill()
    {
        return $this->skill;
    }

    /**
     * Set experience.
     *
     * @param string $experience
     *
     * @return MatchApplication
     */
    public function setExperience($experience)
    {
        $this->experience = $experience;

        return $this;
    }

    /**
     * Get experience.
     *
     * @return string
     */
    public function getExperience()
    {
        return $this->experience;
    }

    /**
     * Set people.
     *
     * @param int $people
     *
     * @return MatchApplication
     */
    public function setPeople($people)
    {
        $this->people = $people;

        return $this;
    }

    /**
     * Get people.
     *
     * @return int
     */
    public function getPeople()
    {
        return $this->people;
    }

    /**
     * Set totalPeople.
     *
     * @param int $totalPeople
     *
     * @return MatchApplication
     */
    public function setTotalPeople($totalPeople)
    {
        $this->totalPeople = $totalPeople;

        return $this;
    }

    /**
     * Get totalPeople.
     *
     * @return int
     */
    public function getTotalPeople()
    {
        return $this->totalPeople;
    }

    /**
     * Set joinEndAt.
     *
     * @param \DateTime $joinEndAt
     *
     * @return MatchApplication
     */
    public function setJoinEndAt($joinEndAt)
    {
        $this->joinEndAt = $joinEndAt;

        return $this;
    }

    /**
     * Get joinEndAt.
     *
     * @return \DateTime
     */
    public function getJoinEndAt()
    {
        return $this->joinEndAt;
    }

    /**
     * Set extra.
     *
     * @param string|null $extra
     *
     * @return MatchApplication
     */
    public function setExtra($extra = null)
    {
        $this->extra = $extra;

        return $this;
    }

    /**
     * Get extra.
     *
     * @return string|null
     */
    public function getExtra()
    {
        return $this->extra;
    }

    /**
     * Set isSponsor.
     *
     * @param bool $isSponsor
     *
     * @return MatchApplication
     */
    public function setIsSponsor($isSponsor)
    {
        $this->isSponsor = $isSponsor;

        return $this;
    }

    /**
     * Get isSponsor.
     *
     * @return bool
     */
    public function getIsSponsor()
    {
        return $this->isSponsor;
    }

    /**
     * Set matchExperience.
     *
     * @param string $matchExperience
     *
     * @return MatchApplication
     */
    public function setMatchExperience($matchExperience)
    {
        $this->matchExperience = $matchExperience;

        return $this;
    }

    /**
     * Get matchExperience.
     *
     * @return string
     */
    public function getMatchExperience()
    {
        return $this->matchExperience;
    }

    /**
     * Set contact.
     *
     * @param string $contact
     *
     * @return MatchApplication
     */
    public function setContact($contact)
    {
        $this->contact = $contact;

        return $this;
    }

    /**
     * Get contact.
     *
     * @return string
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * Set createdAt.
     *
     * @param \DateTime $createdAt
     *
     * @return MatchApplication
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
     * @return MatchApplication
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
     * Set matchInfo.
     *
     * @param \CommonBundle\Entity\MatchInfo|null $matchInfo
     *
     * @return MatchApplication
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

    /**
     * Set profile.
     *
     * @param \CommonBundle\Entity\WeappUserProfile|null $profile
     *
     * @return MatchApplication
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
    private $Children;

    /**
     * @var \CommonBundle\Entity\MatchApplication
     */
    private $Parent;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->Children = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add child.
     *
     * @param \CommonBundle\Entity\MatchApplication $child
     *
     * @return MatchApplication
     */
    public function addChild(\CommonBundle\Entity\MatchApplication $child)
    {
        $this->Children[] = $child;

        return $this;
    }

    /**
     * Remove child.
     *
     * @param \CommonBundle\Entity\MatchApplication $child
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeChild(\CommonBundle\Entity\MatchApplication $child)
    {
        return $this->Children->removeElement($child);
    }

    /**
     * Get children.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChildren()
    {
        return $this->Children;
    }

    /**
     * Set parent.
     *
     * @param \CommonBundle\Entity\MatchApplication|null $parent
     *
     * @return MatchApplication
     */
    public function setParent(\CommonBundle\Entity\MatchApplication $parent = null)
    {
        $this->Parent = $parent;

        return $this;
    }

    /**
     * Get parent.
     *
     * @return \CommonBundle\Entity\MatchApplication|null
     */
    public function getParent()
    {
        return $this->Parent;
    }
    /**
     * @var string
     */
    private $skills;


    /**
     * Set skills.
     *
     * @param string $skills
     *
     * @return MatchApplication
     */
    public function setSkills($skills)
    {
        $this->skills = $skills;

        return $this;
    }

    /**
     * Get skills.
     *
     * @return string
     */
    public function getSkills()
    {
        return $this->skills;
    }
    /**
     * @var string|null
     */
    private $teamName;


    /**
     * Set teamName.
     *
     * @param string|null $teamName
     *
     * @return MatchApplication
     */
    public function setTeamName($teamName = null)
    {
        $this->teamName = $teamName;

        return $this;
    }

    /**
     * Get teamName.
     *
     * @return string|null
     */
    public function getTeamName()
    {
        return $this->teamName;
    }

    /**
     * Set isLock.
     *
     * @param bool $isLock
     *
     * @return MatchApplication
     */
    public function setIsLock($isLock)
    {
        $this->isLock = $isLock;

        return $this;
    }

    /**
     * Get isLock.
     *
     * @return bool
     */
    public function getIsLock()
    {
        return $this->isLock;
    }
}
