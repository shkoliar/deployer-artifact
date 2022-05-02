<?php
/** @noinspection PhpUnhandledExceptionInspection */

namespace Deployer;

import('recipe/magento2.php');
import(__DIR__ . '/vendor/autoload.php'); // autoload your project dependencies...
import('recipe/artifact.php'); // ... which will include our recipe

// Set the path to the local artifact file that you want to upload to the server
set('artifact_path', __DIR__ . '/artifacts/build.zip');
// (you could also supply this as an argument: dep deploy -o artifact_path=$(pwd)/artifacts/build.zip

// Redefine deploy procedure to avoid tasks we don't need from the magento2 recipe
task('deploy', [
    // Being [deploy:prepare] replacements
    'artifact:info', // instead of deploy:info
    'deploy:setup',
    'deploy:lock',
    'deploy:release',
    'deploy:artifact', // instead of deploy:update_code
    'deploy:shared',
    'deploy:writable',
    // End [deploy:prepare] replacements
    /*
     * The artifact is expected to already have compiled DI and Assets, so the following tasks are not usually needed:
     *   - deploy:vendors
     *   - deploy:clear_paths
     *   - deploy:magento
     *     - magento:build
     *       - magento:compile
     *       - magento:sync:content_version
     *       - magento:deploy:assets
     */
    // Being [deploy:magento] replacements
    'magento:config:import',
    'magento:upgrade:db',
    'magento:cache:flush',
    // End [deploy:magento] replacements
    'deploy:publish',
]);