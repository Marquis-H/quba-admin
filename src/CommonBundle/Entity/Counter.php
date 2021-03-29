<?php

namespace CommonBundle\Entity;

/**
 * Counter
 */
class Counter
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $slug;

    /**
     * @var int
     */
    private $counter;

    /**
     * @var \DateTime
     */
    private $createdAt;


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
     * @param int $slug
     *
     * @return Counter
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug.
     *
     * @return int
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set counter.
     *
     * @param int $counter
     *
     * @return Counter
     */
    public function setCounter($counter)
    {
        $this->counter = $counter;

        return $this;
    }

    /**
     * Get counter.
     *
     * @return int
     */
    public function getCounter()
    {
        return $this->counter;
    }

    /**
     * Set createdAt.
     *
     * @param \DateTime $createdAt
     *
     * @return Counter
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
}
