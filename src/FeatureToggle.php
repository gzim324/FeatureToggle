<?php

namespace FeatureToggle;

/**
 * FeatureToggle.
 *
 * @author Michal Zimka <michal.zimka@gmail.com>
 */
class FeatureToggle
{
    private string $name;
    private bool $active;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;
        return $this;
    }
}
