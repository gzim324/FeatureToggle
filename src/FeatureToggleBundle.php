<?php

namespace FeatureToggle;

use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use FeatureToggle\DependencyInjection\FeatureToggleExtension;

/**
 * FeatureToggle.
 *
 * @author Michal Zimka <michal.zimka@gmail.com>
 */
class FeatureToggleBundle extends Bundle
{
    public function getContainerExtension(): ?ExtensionInterface
    {
        if (null === $this->extension) {
            $this->extension = new FeatureToggleExtension();
        }

        return $this->extension;
    }
}
