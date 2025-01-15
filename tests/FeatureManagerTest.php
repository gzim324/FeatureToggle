<?php

namespace FeatureToggle\Tests;

use FeatureToggle\FeatureManager;
use FeatureToggle\FeatureToggle;
use FeatureToggle\Repository\FeatureToggleRepositoryInterface;
use PHPUnit\Framework\TestCase;

/**
 * FeatureToggle.
 *
 * @author Michal Zimka <michal.zimka@gmail.com>
 */
class FeatureManagerTest extends TestCase
{
    public function testFeatureIsActive(): void
    {
        $repositoryMock = $this->createMock(FeatureToggleRepositoryInterface::class);
        $repositoryMock->method('findByName')->willReturn(
            new FeatureToggle()->setName('test')->setActive(true)
        );

        $featureManager = new FeatureManager($repositoryMock);

        $this->assertTrue($featureManager->isActive('test'));
    }

    public function testFeatureIsInactive(): void
    {
        $repositoryMock = $this->createMock(FeatureToggleRepositoryInterface::class);
        $repositoryMock->method('findByName')->willReturn(null);

        $featureManager = new FeatureManager($repositoryMock);

        $this->assertFalse($featureManager->isActive('test'));
    }
}
