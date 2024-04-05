<?php
/*
 *  (c) Gabriel Somoza <gabriel@somoza.me>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
/** @noinspection PhpUnhandledExceptionInspection */
declare(strict_types=1);

namespace Deployer;

use Aws\S3\S3Client;

set('aws_s3_signed_url', function() {
    $target = get('target');
    if (empty($target)) {
        throw new \InvalidArgumentException('No "target" specified');
    }
    $result = \preg_match('#^s3://([^/]+)/([^/].*)$#', $target, $matches);
    if (!$result || \count($matches) !== 3) {
        throw new \InvalidArgumentException(
            'If the "path" argument is set, it must contain a valid S3 URI, e.g: ' .
            's3://my-bucket/builds/my-object.zip'
        );
    }
    $bucket = $matches[1];
    $key = $matches[2];
    set('aws-s3-key', $key);

    $s3Client = new S3Client([
        'profile' => get('aws-profile', 'default'),
        'region' => get('aws-region', 'eu-central-1'),
        'version' => get('aws-version', '2006-03-01'),
    ]);

    $cmd = $s3Client->getCommand('GetObject', [
        'Bucket' => $bucket,
        'Key' => $key,
    ]);

    $request = $s3Client->createPresignedRequest($cmd, '+20 minutes');

    return (string) $request->getUri();
});

task('artifact:s3:deploy', function () {
    if (!commandExist('wget')) {
        throw new \RuntimeException(\sprintf("Host %s doesn't support wget command", currentHost()));
    }

    $uploadDir = get('artifact_upload_dir');
    $signedUrl = get('aws_s3_signed_url');
    $key = get('aws-s3-key');
    $filename = \basename($key);

    run("mkdir -p {$uploadDir}");
    info("Downloading artifact from S3, this might take a while...");
    run("rm -f {$uploadDir}/{$filename} && wget -q -O {$uploadDir}/{$filename} \"{$signedUrl}\"");
});

task('artifact:deploy', [
    'artifact:s3:deploy',
]);
