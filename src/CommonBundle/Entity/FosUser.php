<?php


namespace CommonBundle\Entity;

use FOS\UserBundle\Model\FosUserInterface;
use FOS\UserBundle\Model\User;
use Symfony\Component\Security\Core\User\UserInterface;


/**
 * Class FosUser
 * @package CommonBundle\Entity
 */
class FosUser extends User
{
    /**
     * 實時切換用戶ROLE
     * @param UserInterface $user
     * @return bool
     */
    public function isEqualTo(UserInterface $user)
    {
        return serialize($user->getRoles()) === serialize($this->getRoles());
    }

    /**
     * @return array
     */
    public function getRoles()
    {
        $roles = $this->roles;
        // we need to make sure to have at least one role
        $roles[] = static::ROLE_DEFAULT;
        return array_unique($roles);
    }

    /**
     * @return bool
     */
    public function getEnable()
    {
        return $this->enabled;
    }

    /**
     * @param bool $enabled
     * @return FosUserInterface|User|void
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    }

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $firstName;

    /**
     * @var string
     */
    protected $lastName;

    /**
     * @var string
     */
    private $name;

    /**
     * @var array
     */
    protected $configs = array();

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getFullName()
    {
        return $this->getLastName() . $this->getFirstName();
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return array
     */
    public function getConfigs()
    {
        return $this->configs;
    }

    /**
     * @param array $configs
     */
    public function setConfigs(array $configs)
    {
        $this->configs = $configs;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return FosUser
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
}
