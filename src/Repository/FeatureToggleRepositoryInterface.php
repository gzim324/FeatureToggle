<?php

namespace FeatureToggle\Repository;

use FeatureToggle\FeatureToggle;

/**
 * FeatureToggle.
 *
 * @author Michal Zimka <michal.zimka@gmail.com>
 */
interface FeatureToggleRepositoryInterface
{
    public function findByName(string $name): ?FeatureToggle;

    public function findAll(): array;
}
