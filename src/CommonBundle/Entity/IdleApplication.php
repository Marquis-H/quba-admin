<?php

namespace CommonBundle\Entity;

/**
 * IdleApplication
 */
class IdleApplication
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
    private $description;

    /**
     * @var string
     */
    private $status;

    /**
     * @var int
     */
    private $oldDeep = 0;

    /**
     * @var int
     */
    private $number = 1;

    /**
     * @var float
     */
    private $originalCost;

    /**
     * @var float
     */
    private $currentCost;

    /**
     * @var string
     */
    private $contactType;

    /**
     * @var string
     */
    private $contact;

    /**
     * @var string|null
     */
    private $originalUrl;

    /**
     * @var string|null
     */
    private $remark;

    /**
     * @var string
     */
    private $famousPhoto;

    /**
     * @var array
     */
    private $photos;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @var \CommonBundle\Entity\IdleCategory
     */
    private $IdleCategory;

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
     * Set title.
     *
     * @param string $title
     *
     * @return IdleApplication
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
     * @param string $description
     *
     * @return IdleApplication
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set status.
     *
     * @param string $status
     *
     * @return IdleApplication
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
     * Set oldDeep.
     *
     * @param int $oldDeep
     *
     * @return IdleApplication
     */
    public function setOldDeep($oldDeep)
    {
        $this->oldDeep = $oldDeep;

        return $this;
    }

    /**
     * Get oldDeep.
     *
     * @return int
     */
    public function getOldDeep()
    {
        return $this->oldDeep;
    }

    /**
     * Set number.
     *
     * @param int $number
     *
     * @return IdleApplication
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number.
     *
     * @return int
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set originalCost.
     *
     * @param float $originalCost
     *
     * @return IdleApplication
     */
    public function setOriginalCost($originalCost)
    {
        $this->originalCost = $originalCost;

        return $this;
    }

    /**
     * Get originalCost.
     *
     * @return float
     */
    public function getOriginalCost()
    {
        return $this->originalCost;
    }

    /**
     * Set currentCost.
     *
     * @param float $currentCost
     *
     * @return IdleApplication
     */
    public function setCurrentCost($currentCost)
    {
        $this->currentCost = $currentCost;

        return $this;
    }

    /**
     * Get currentCost.
     *
     * @return float
     */
    public function getCurrentCost()
    {
        return $this->currentCost;
    }

    /**
     * Set contactType.
     *
     * @param string $contactType
     *
     * @return IdleApplication
     */
    public function setContactType($contactType)
    {
        $this->contactType = $contactType;

        return $this;
    }

    /**
     * Get contactType.
     *
     * @return string
     */
    public function getContactType()
    {
        return $this->contactType;
    }

    /**
     * Set contact.
     *
     * @param string $contact
     *
     * @return IdleApplication
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
     * Set originalUrl.
     *
     * @param string|null $originalUrl
     *
     * @return IdleApplication
     */
    public function setOriginalUrl($originalUrl = null)
    {
        $this->originalUrl = $originalUrl;

        return $this;
    }

    /**
     * Get originalUrl.
     *
     * @return string|null
     */
    public function getOriginalUrl()
    {
        return $this->originalUrl;
    }

    /**
     * Set remark.
     *
     * @param string|null $remark
     *
     * @return IdleApplication
     */
    public function setRemark($remark = null)
    {
        $this->remark = $remark;

        return $this;
    }

    /**
     * Get remark.
     *
     * @return string|null
     */
    public function getRemark()
    {
        return $this->remark;
    }

    /**
     * Set famousPhoto.
     *
     * @param string $famousPhoto
     *
     * @return IdleApplication
     */
    public function setFamousPhoto($famousPhoto)
    {
        $this->famousPhoto = $famousPhoto;

        return $this;
    }

    /**
     * Get famousPhoto.
     *
     * @return string
     */
    public function getFamousPhoto()
    {
        return $this->famousPhoto;
    }

    /**
     * Set photos.
     *
     * @param array $photos
     *
     * @return IdleApplication
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
     * @return IdleApplication
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
     * @return IdleApplication
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
     * Set idleCategory.
     *
     * @param \CommonBundle\Entity\IdleCategory|null $idleCategory
     *
     * @return IdleApplication
     */
    public function setIdleCategory(\CommonBundle\Entity\IdleCategory $idleCategory = null)
    {
        $this->IdleCategory = $idleCategory;

        return $this;
    }

    /**
     * Get idleCategory.
     *
     * @return \CommonBundle\Entity\IdleCategory|null
     */
    public function getIdleCategory()
    {
        return $this->IdleCategory;
    }

    /**
     * Set profile.
     *
     * @param \CommonBundle\Entity\WeappUserProfile|null $profile
     *
     * @return IdleApplication
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
     * @var \DateTime|null
     */
    private $topAt;


    /**
     * Set topAt.
     *
     * @param \DateTime|null $topAt
     *
     * @return IdleApplication
     */
    public function setTopAt($topAt = null)
    {
        $this->topAt = $topAt;

        return $this;
    }

    /**
     * Get topAt.
     *
     * @return \DateTime|null
     */
    public function getTopAt()
    {
        return $this->topAt;
    }
}
