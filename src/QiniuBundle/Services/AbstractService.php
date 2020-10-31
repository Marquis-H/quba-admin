<?php


namespace QiniuBundle\Services;

use Symfony\Component\DependencyInjection\ContainerInterface;

class AbstractService
{
    /** @var ContainerInterface */
    public $container;

    /**
     * BannerService constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
}
