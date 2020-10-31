<?php

namespace CommonBundle\Entity;

/**
 * IdleCategory
 */
class IdleCategory
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
     * @var string|null
     */
    private $description;

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
    private $IdleApplication;

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
     * @return IdleCategory
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
     * Set description.
     *
     * @param string|null $description
     *
     * @return IdleCategory
     */
    public function setDescription($description = null)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string|null
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set createdAt.
     *
     * @param \DateTime $createdAt
     *
     * @return IdleCategory
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
     * @return IdleCategory
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
     * Constructor
     */
    public function __construct()
    {
        $this->IdleApplication = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add idleApplication.
     *
     * @param \CommonBundle\Entity\IdleApplication $idleApplication
     *
     * @return IdleCategory
     */
    public function addIdleApplication(\CommonBundle\Entity\IdleApplication $idleApplication)
    {
        $this->IdleApplication[] = $idleApplication;

        return $this;
    }

    /**
     * Remove idleApplication.
     *
     * @param \CommonBundle\Entity\IdleApplication $idleApplication
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeIdleApplication(\CommonBundle\Entity\IdleApplication $idleApplication)
    {
        return $this->IdleApplication->removeElement($idleApplication);
    }

    /**
     * Get idleApplication.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIdleApplication()
    {
        return $this->IdleApplication;
    }
}
