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

task('artifact:upload', function() {
    $sourcePath = get('target');
    $realpath = \realpath($sourcePath);
    if ($realpath === false) {
        throw new \Exception("Artifact cannot be found locally at $sourcePath, please check 'artifact_path'.");
    }

    $uploadDir = get('artifact_upload_dir');

    info("Uploading artifact from $realpath...");
    upload($realpath, "$uploadDir/", ['progress_bar' => true, 'options' => ['--bwlimit=4096']]);
});

task('artifact:deploy', [
    'artifact:upload'
]);
