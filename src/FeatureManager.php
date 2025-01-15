<?php

namespace FeatureToggle;

use FeatureToggle\Repository\FeatureToggleRepositoryInterface;

/**
 * FeatureToggle.
 *
 * @author Michal Zimka <michal.zimka@gmail.com>
 */
readonly class FeatureManager
{
    public function __construct(
        private FeatureToggleRepositoryInterface $repository,
    ) {}

    public function isActive(string $featureName): bool
    {
        $feature = $this->repository->findByName($featureName);

        return $feature?->isActive() ?? false;
    }

    public function listToggles(): array
    {
        return $this->repository->findAll();
    }
}
