<?php

namespace CommonBundle\Entity;

use DateTime;
use Lexik\Bundle\JWTAuthenticationBundle\Security\User\JWTUserInterface;
use Util\Str;

/**
 * WeappUser
 */
class WeappUser implements JWTUserInterface
{
    public function getPassword()
    {
        // TODO: Implement getPassword() method.
    }

    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    public function getUsername()
    {
        return $this->getOpenID();
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    /**
     * {@inheritdoc}
     */
    public function doStuffOnPrePersist()
    {
        $this->setUsername(Str::generateUniqidString());
    }

    public static function createFromPayload($openID, array $payload)
    {
        $member = new self();
        $member->openID = $openID;
        return $member;
    }

    public function getRoles()
    {
        return ['app'];
    }

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $openID;

    /**
     * @var string|null
     */
    private $nickname;

    /**
     * @var string|null
     */
    private $avatar;

    /**
     * @var DateTime
     */
    private $createdAt;

    /**
     * @var DateTime
     */
    private $updatedAt;

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
     * Set openID.
     *
     * @param string $openID
     *
     * @return WeappUser
     */
    public function setOpenID($openID)
    {
        $this->openID = $openID;

        return $this;
    }

    /**
     * Get openID.
     *
     * @return string
     */
    public function getOpenID()
    {
        return $this->openID;
    }

    /**
     * Set nickname.
     *
     * @param string|null $nickname
     *
     * @return WeappUser
     */
    public function setNickname($nickname = null)
    {
        $this->nickname = $nickname;

        return $this;
    }

    /**
     * Get nickname.
     *
     * @return string|null
     */
    public function getNickname()
    {
        return $this->nickname;
    }

    /**
     * Set avatar.
     *
     * @param string|null $avatar
     *
     * @return WeappUser
     */
    public function setAvatar($avatar = null)
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * Get avatar.
     *
     * @return string|null
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * Set createdAt.
     *
     * @param DateTime $createdAt
     *
     * @return WeappUser
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt.
     *
     * @return DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt.
     *
     * @param DateTime $updatedAt
     *
     * @return WeappUser
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt.
     *
     * @return DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @var string
     */
    private $username;


    /**
     * Set username.
     *
     * @param string $username
     *
     * @return WeappUser
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }
    /**
     * @var \DateTime|null
     */
    private $lastLoginAt;

    /**
     * @var string|null
     */
    private $lastLoginIp;


    /**
     * Set lastLoginAt.
     *
     * @param \DateTime|null $lastLoginAt
     *
     * @return WeappUser
     */
    public function setLastLoginAt($lastLoginAt = null)
    {
        $this->lastLoginAt = $lastLoginAt;

        return $this;
    }

    /**
     * Get lastLoginAt.
     *
     * @return \DateTime|null
     */
    public function getLastLoginAt()
    {
        return $this->lastLoginAt;
    }

    /**
     * Set lastLoginIp.
     *
     * @param string|null $lastLoginIp
     *
     * @return WeappUser
     */
    public function setLastLoginIp($lastLoginIp = null)
    {
        $this->lastLoginIp = $lastLoginIp;

        return $this;
    }

    /**
     * Get lastLoginIp.
     *
     * @return string|null
     */
    public function getLastLoginIp()
    {
        return $this->lastLoginIp;
    }

    /**
     * @var \CommonBundle\Entity\WeappUserProfile
     */
    private $WeappUserProfile;


    /**
     * Set weappUserProfile.
     *
     * @param \CommonBundle\Entity\WeappUserProfile|null $weappUserProfile
     *
     * @return WeappUser
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
}
