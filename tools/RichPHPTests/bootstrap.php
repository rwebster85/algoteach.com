<?php

/*
 * This file is part of RichPHPTests.
 *
 * Copyright (c) Richard Webster
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace RichPHPTests;

use const DIRECTORY_SEPARATOR as SEP;

(function() use ($tests_folder, $config_file) {
    $path = __DIR__ . SEP;
    $includes = $path . 'Includes' . SEP;

    require_once $includes . SEP . 'Interfaces' . SEP . 'ProjectInterface.php';
    require_once $includes . 'Project.php';
    $project = new Project($path . 'project.json', __DIR__);
    $project->buildProject();

    require_once $includes . 'Autoload' . SEP . 'Autoloader.php';
    (new Autoload\Autoloader($project->getAutoloaderSources()))->register();

    (new FileLoader(...$project->getFileSources()))->loadFiles();

    $config = new TestsConfiguration($config_file, $tests_folder);

    Application::instance($config);

    if (SourceChecker::isCli()) {
        if (Application::getTestResults()->getTotalFailed() > 0) {
            print("\e[0;31mTests completed with failures.\e[0m");
        } else {
            print("\e[0;32mTests completed without failures.\e[0m");
        }
        print(PHP_EOL);
        Application::getTestResults()->printResults();
    }
})();
