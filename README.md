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
Then create a repository implementing `FeatureToggle\Repository\FeatureToggleRepositoryInterface` and set this class in
`feature_toggle.yaml`.

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

## Command: `toggle:list`

The `php bin/console toggle:list` command allows you to manage and view the list of feature toggles in your application.

### Syntax

```bash
   php bin/console toggle:list [--active=<value>]
```

### Options

- `--active=<value>` (optional): Filters the results based on the status of feature toggles. Possible values:
    - `true` - Returns only active feature toggles.
    - `false` - Returns only inactive feature toggles.
    - If the option is not provided, the full list of feature toggles is displayed.

### Usage Examples

1. Display the full list of feature toggles:
   ```bash
   php bin/console toggle:list
   ```

2. Display only active feature toggles:
   ```bash
   php bin/console toggle:list --active=true
   ```

3. Display only inactive feature toggles:
   ```bash
   php bin/console toggle:list --active=false
   ```

### Sample Output

```plaintext
+-------------------+-----------+
| Feature Toggle    | Active    |
+-------------------+-----------+
| feature_toggle_1  | ACTIVE    |
| feature_toggle_2  | INSCTIVE  |
| feature_toggle_3  | ACTIVE    |
+-------------------+-----------+
```
