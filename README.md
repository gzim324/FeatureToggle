# Feature Toggle Bundle

Feature Toggle Bundle for Symfony provides an easy way to manage feature flags in your Symfony applications.

## Installation

```bash
composer require michalzimka/feature-toggle
```

## Configuration

Create a repository implementing `FeatureToggle\Repository\FeatureToggleRepositoryInterface` and configure it in your services.

## Usage

```php
use FeatureToggle\FeatureManager;

$featureManager = new FeatureManager($yourRepository);

if ($featureManager->isActive('new_awesome_feature')) {
    // Awesome feature is active
}
```

