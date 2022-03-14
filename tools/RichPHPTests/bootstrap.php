<?php

/*
 * This file is part of RichPHPTests.
 *
 * Copyright (c) Richard Webster
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RichPHPTests;

use const DIRECTORY_SEPARATOR as SEP;

$path = __DIR__ . SEP;
$includes = $path . 'Includes' . SEP;

require_once $includes . 'Project.php';
$project = new Project($path . 'project.json', __DIR__);

require_once $includes . 'Autoload' . SEP . 'Autoloader.php';
(new Autoload\Autoloader($project->getAutoloaderSources()))->register();

(new FileLoader(...$project->getFileSources()))->loadFiles();

$config = new TestsConfiguration($config_file, $tests_folder);

$app = Application::instance($config);

if (SourceChecker::isCli()) {
    print('Tests complete.' . PHP_EOL);
    Application::getTestResults()->printResults();
}
