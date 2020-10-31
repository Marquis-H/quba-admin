<?php

namespace CommonBundle\Entity;

/**
 * WeappUserApiKey
 */
class WeappUserApiKey
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $apiKey;

    /**
     * @var \DateTime|null
     */
    private $lastRequestedAt;

    /**
     * @var string|null
     */
    private $lastRequestedIp;

    /**
     * @var \CommonBundle\Entity\WeappUser
     */
    private $WeappUser;


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
     * Set apiKey.
     *
     * @param string $apiKey
     *
     * @return WeappUserApiKey
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;

        return $this;
    }

    /**
     * Get apiKey.
     *
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * Set lastRequestedAt.
     *
     * @param \DateTime|null $lastRequestedAt
     *
     * @return WeappUserApiKey
     */
    public function setLastRequestedAt($lastRequestedAt = null)
    {
        $this->lastRequestedAt = $lastRequestedAt;

        return $this;
    }

    /**
     * Get lastRequestedAt.
     *
     * @return \DateTime|null
     */
    public function getLastRequestedAt()
    {
        return $this->lastRequestedAt;
    }

    /**
     * Set lastRequestedIp.
     *
     * @param string|null $lastRequestedIp
     *
     * @return WeappUserApiKey
     */
    public function setLastRequestedIp($lastRequestedIp = null)
    {
        $this->lastRequestedIp = $lastRequestedIp;

        return $this;
    }

    /**
     * Get lastRequestedIp.
     *
     * @return string|null
     */
    public function getLastRequestedIp()
    {
        return $this->lastRequestedIp;
    }

    /**
     * Set weappUser.
     *
     * @param \CommonBundle\Entity\WeappUser $weappUser
     *
     * @return WeappUserApiKey
     */
    public function setWeappUser(\CommonBundle\Entity\WeappUser $weappUser)
    {
        $this->WeappUser = $weappUser;

        return $this;
    }

    /**
     * Get weappUser.
     *
     * @return \CommonBundle\Entity\WeappUser
     */
    public function getWeappUser()
    {
        return $this->WeappUser;
    }
}
