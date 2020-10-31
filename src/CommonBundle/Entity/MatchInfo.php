<?php

namespace CommonBundle\Entity;

/**
 * MatchInfo
 */
class MatchInfo
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
     * @var array
     */
    private $tabs;

    /**
     * @var \DateTime|null
     */
    private $endAt;

    /**
     * @var int
     */
    private $peopleLimit = 0;

    /**
     * @var string|null
     */
    private $qualificationLimit;

    /**
     * @var array
     */
    private $files;

    /**
     * @var string|null
     */
    private $urls;

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
    private $MatchApplication;

    /**
     * @var \CommonBundle\Entity\MatchCategory
     */
    private $MatchCategory;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->MatchApplication = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return MatchInfo
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
     * Set tabs.
     *
     * @param array $tabs
     *
     * @return MatchInfo
     */
    public function setTabs($tabs)
    {
        $this->tabs = $tabs;

        return $this;
    }

    /**
     * Get tabs.
     *
     * @return array
     */
    public function getTabs()
    {
        return $this->tabs;
    }

    /**
     * Set endAt.
     *
     * @param \DateTime|null $endAt
     *
     * @return MatchInfo
     */
    public function setEndAt($endAt = null)
    {
        $this->endAt = $endAt;

        return $this;
    }

    /**
     * Get endAt.
     *
     * @return \DateTime|null
     */
    public function getEndAt()
    {
        return $this->endAt;
    }

    /**
     * Set peopleLimit.
     *
     * @param int $peopleLimit
     *
     * @return MatchInfo
     */
    public function setPeopleLimit($peopleLimit)
    {
        $this->peopleLimit = $peopleLimit;

        return $this;
    }

    /**
     * Get peopleLimit.
     *
     * @return int
     */
    public function getPeopleLimit()
    {
        return $this->peopleLimit;
    }

    /**
     * Set qualificationLimit.
     *
     * @param string|null $qualificationLimit
     *
     * @return MatchInfo
     */
    public function setQualificationLimit($qualificationLimit = null)
    {
        $this->qualificationLimit = $qualificationLimit;

        return $this;
    }

    /**
     * Get qualificationLimit.
     *
     * @return string|null
     */
    public function getQualificationLimit()
    {
        return $this->qualificationLimit;
    }

    /**
     * Set files.
     *
     * @param array $files
     *
     * @return MatchInfo
     */
    public function setFiles($files)
    {
        $this->files = $files;

        return $this;
    }

    /**
     * Get files.
     *
     * @return array
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * Set urls.
     *
     * @param string|null $urls
     *
     * @return MatchInfo
     */
    public function setUrls($urls = null)
    {
        $this->urls = $urls;

        return $this;
    }

    /**
     * Get urls.
     *
     * @return string|null
     */
    public function getUrls()
    {
        return $this->urls;
    }

    /**
     * Set createdAt.
     *
     * @param \DateTime $createdAt
     *
     * @return MatchInfo
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
     * @return MatchInfo
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
     * Add matchApplication.
     *
     * @param \CommonBundle\Entity\MatchApplication $matchApplication
     *
     * @return MatchInfo
     */
    public function addMatchApplication(\CommonBundle\Entity\MatchApplication $matchApplication)
    {
        $this->MatchApplication[] = $matchApplication;

        return $this;
    }

    /**
     * Remove matchApplication.
     *
     * @param \CommonBundle\Entity\MatchApplication $matchApplication
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeMatchApplication(\CommonBundle\Entity\MatchApplication $matchApplication)
    {
        return $this->MatchApplication->removeElement($matchApplication);
    }

    /**
     * Get matchApplication.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMatchApplication()
    {
        return $this->MatchApplication;
    }

    /**
     * Set matchCategory.
     *
     * @param \CommonBundle\Entity\MatchCategory|null $matchCategory
     *
     * @return MatchInfo
     */
    public function setMatchCategory(\CommonBundle\Entity\MatchCategory $matchCategory = null)
    {
        $this->MatchCategory = $matchCategory;

        return $this;
    }

    /**
     * Get matchCategory.
     *
     * @return \CommonBundle\Entity\MatchCategory|null
     */
    public function getMatchCategory()
    {
        return $this->MatchCategory;
    }
}
