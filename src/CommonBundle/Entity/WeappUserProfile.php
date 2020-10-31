<?php

namespace CommonBundle\Entity;

/**
 * WeappUserProfile
 */
class WeappUserProfile
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $gender;

    /**
     * @var string
     */
    private $mobile;

    /**
     * @var string
     */
    private $sNo;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @var \CommonBundle\Entity\College
     */
    private $College;

    /**
     * @var \CommonBundle\Entity\Professional
     */
    private $Professional;


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
     * Set name.
     *
     * @param string $name
     *
     * @return WeappUserProfile
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set gender.
     *
     * @param string $gender
     *
     * @return WeappUserProfile
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender.
     *
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set mobile.
     *
     * @param string $mobile
     *
     * @return WeappUserProfile
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;

        return $this;
    }

    /**
     * Get mobile.
     *
     * @return string
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * Set sNo.
     *
     * @param string $sNo
     *
     * @return WeappUserProfile
     */
    public function setSNo($sNo)
    {
        $this->sNo = $sNo;

        return $this;
    }

    /**
     * Get sNo.
     *
     * @return string
     */
    public function getSNo()
    {
        return $this->sNo;
    }

    /**
     * Set createdAt.
     *
     * @param \DateTime $createdAt
     *
     * @return WeappUserProfile
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
     * @return WeappUserProfile
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
     * Set college.
     *
     * @param \CommonBundle\Entity\College|null $college
     *
     * @return WeappUserProfile
     */
    public function setCollege(\CommonBundle\Entity\College $college = null)
    {
        $this->College = $college;

        return $this;
    }

    /**
     * Get college.
     *
     * @return \CommonBundle\Entity\College|null
     */
    public function getCollege()
    {
        return $this->College;
    }

    /**
     * Set professional.
     *
     * @param \CommonBundle\Entity\Professional|null $professional
     *
     * @return WeappUserProfile
     */
    public function setProfessional(\CommonBundle\Entity\Professional $professional = null)
    {
        $this->Professional = $professional;

        return $this;
    }

    /**
     * Get professional.
     *
     * @return \CommonBundle\Entity\Professional|null
     */
    public function getProfessional()
    {
        return $this->Professional;
    }
}
