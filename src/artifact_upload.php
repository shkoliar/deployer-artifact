<?php
/** @noinspection PhpUnhandledExceptionInspection */
declare(strict_types=1);

namespace Deployer;

// the local path to the artifact
set('artifact_path', function() {
    $path = '';
    if (input()->hasOption('artifact') && !empty(input()->getOption('artifact'))) {
        $path = input()->getOption('artifact');
    }
    $realPath = \realpath($path);
    if ($realPath === false) {
        throw new \Exception("Artifact cannot be found locally, please check 'artifact_path'.");
    }
});

set('artifact_dest_path', function() {
    $uploadDir = \rtrim(get('artifact_upload_dir'), '/') ;
    $artifactSourcePath = get('artifact_path');
    return $uploadDir . '/' . \basename($artifactSourcePath);
});

task('artifact:upload', function() {
    $artifactSourcePath = get('artifact_path');
    $uploadDir = get('artifact_upload_dir');

    if (!testLocally("[ -f $artifactSourcePath ]")) {
        throw error('Artifact could not be found locally at ' . $artifactSourcePath);
    }

    info("Uploading artifact from $artifactSourcePath...");
    upload($artifactSourcePath, "$uploadDir/", ['progress_bar' => true, 'options' => ['--bwlimit=4096']]);
});

task('artifact:extract', function() {
    within('{{release_path}}', function() {
        $artifactPath = get('artifact_dest_path');

        // Tar
        if (\preg_match('#\.tar\..*?$#', $artifactPath)) {
            run("tar --overwrite -xf {{artifact_upload_dir}}/deployer.tar.gz 2>&1");
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
