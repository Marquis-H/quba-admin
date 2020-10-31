<?php


namespace QiniuBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\PropertyAccess\PropertyAccess;

class QiniuExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $accessor = PropertyAccess::createPropertyAccessor();

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');

        $accessKey = $accessor->getValue($config, '[access_key]');
        $secretKey = $accessor->getValue($config, '[secret_key]');
        $domain = $accessor->getValue($config, '[domain]');

        if ($accessKey && $secretKey) {
            $definition = new Definition('QiniuBundle\Helpers\Client', array($accessKey, $secretKey));
            $container->setDefinition('qiniu.client', $definition);
        }

        $container->setParameter('qiniu.domain', $domain === null ? '' : $domain);
    }

}
