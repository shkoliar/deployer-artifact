# Artifact Deployer
This recipe deploys artifacts using [Deployer|https://deployer.org].

## Installation
1) Install Deployer in your project. 

2) Then require this recipe:
```shell
composer require gsomoza/deployer-artifact "^0.1"
```

## Usage
1) Import the recipe in your `deploy.php` script:
```php
<?php
// assumes you're running Deployer via PHAR: 
import(__DIR__ . 'vendor/autoload.php');
import('recipe/artifact.php');
```

2) Set `artifact_path` to the local path where your artifact is located.
```php
<?php
set('artifact_path', 'build/project.zip');
```

3) Use the `deploy:artifact` task or any of its sub-tasks.

## Examples
You can find example setups in the [examples|https://github.com/gsomoza/deployer-artifact/tree/main/examples] folder.