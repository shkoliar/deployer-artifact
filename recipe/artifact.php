<?php
/* (c) Gabriel Somoza <gabriel@somoza.me>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
/** @noinspection PhpUnhandledExceptionInspection */
declare(strict_types=1);

namespace Deployer;

import(__DIR__ . '/artifact_fetch.php');
import(__DIR__ . '/artifact_upload.php');

use Symfony\Component\Console\Input\InputOption;

add('recipes', ['artifact']);

option('artifact', null, InputOption::VALUE_REQUIRED, 'The artifact to upload');

set('artifact_upload_dir', '{{deploy_path}}/.dep/artifact');

task('deploy:artifact', [
    'artifact:fetch',
    'artifact:upload',
    'artifact:extract',
]);

task('artifact:info', function() {
    info("deploying artifact <fg=magenta;options=bold>{{artifact_path}}</>");
});
