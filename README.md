# Feature Toggle Bundle

Feature Toggle Bundle for Symfony provides an easy way to manage feature flags in your Symfony applications.

## Installation

```bash
 composer require michalzimka/feature-toggle
```

## Configuration

You can create `FeatureToggle` entity with properties:
```php
#[ORM\Column(length: 255, unique: true)]
private string $name;

#[ORM\Column(type: 'boolean')]
private bool $active;
```

\
Then create a repository implementing `FeatureToggle\Repository\FeatureToggleRepositoryInterface` and set this class in `feature_toggle.yaml`.

#### For example:

```php
<?php

namespace App\Repository;

use Doctrine\ORM\EntityManagerInterface;
use FeatureToggle\FeatureToggle;
use FeatureToggle\Repository\FeatureToggleRepositoryInterface;
use App\Entity\FeatureToggle as FeatureToggleEntity;

class DatabaseFeatureToggleRepository implements FeatureToggleRepositoryInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {}

    public function findByName(string $name): ?FeatureToggle
    {
        $entity = $this->entityManager
            ->getRepository(FeatureToggleEntity::class)
            ->findOneBy(['name' => $name]);

        if (!$entity) {
            return null;
        }

        return new FeatureToggle()
            ->setName($entity->getName())
            ->setActive($entity->isActive());
    }

    public function findAll(): array
    {
        $entities = $this->entityManager->getRepository(FeatureToggleEntity::class)->findAll();
        $toggles = [];

        foreach ($entities as $entity) {
            $toggles[] = new FeatureToggle()
                ->setName($entity->getName())
                ->setActive($entity->isActive());
        }

        return $toggles;
    }
}
```

## Usage

```php
use FeatureToggle\FeatureManager;

$featureManager = new FeatureManager($yourRepository);

if ($featureManager->isActive('new_awesome_feature')) {
    // Awesome feature is active
}
```

