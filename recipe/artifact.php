<?php
/*
 * (c) Gabriel Somoza <gabriel@somoza.me>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
/** @noinspection PhpUnhandledExceptionInspection */
declare(strict_types=1);

namespace Deployer;

import(__DIR__ . '/artifact_extract.php');

add('recipes', ['artifact']);

/**
 * artifact_upload_dir: path to the directory inside which the artifact will be uploaded
 */
set('artifact_upload_dir', '{{deploy_path}}/.dep/artifact');

/**
 * artifact_dest_path: the final path of the artifact in the host
 */
set('artifact_dest_path', function() {
    $uploadDir = \rtrim(get('artifact_upload_dir'), '/') ;
    $artifactSourcePath = get('target');
    return $uploadDir . '/' . \basename($artifactSourcePath);
});

// TASKS
task('deploy:artifact', [
    'artifact:deploy',
    'artifact:extract',
]);

