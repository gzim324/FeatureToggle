<?php

namespace FeatureToggle\DependencyInjection;

use FeatureToggle\Command\ToggleListCommand;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Reference;

/**
 * FeatureToggle.
 *
 * @author Michal Zimka <michal.zimka@gmail.com>
 */
class FeatureToggleExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        
        $container->setParameter('feature_toggle.repository', $config['repository']);

        $container
            ->register('FeatureToggle\FeatureManager', 'FeatureToggle\FeatureManager')
            ->setArgument('$repository', new Reference($config['repository']))
            ->setPublic(true);

        $container
            ->register(ToggleListCommand::class, ToggleListCommand::class)
            ->addArgument(new Reference('FeatureToggle\FeatureManager'))
            ->addTag('console.command')
            ->setPublic(true);
    }
}
