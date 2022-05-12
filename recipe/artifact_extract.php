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

task('artifact:extract', function() {
    within('{{release_path}}', function() {
        $artifactPath = get('artifact_dest_path');

        // Tar
        if (\preg_match('#\.tar\..*?$#', $artifactPath)) {
            run("tar --overwrite -xf $artifactPath 2>&1");
            return;
        }

        // Zip
        if (\substr($artifactPath, -4) === '.zip') {
            $verbosity = output()->isVeryVerbose() ? '' : '-q';
            run("unzip -o $verbosity $artifactPath 2>&1");
            return;
        }
    });
});
