<?php
/**
 * This file sets up the class autoloader and runs the application.
 */

namespace RichPHPTests;

$sep = DIRECTORY_SEPARATOR;
$path = __DIR__ . $sep;
$includes = __DIR__ . $sep . 'Includes';

require_once $includes . $sep . 'Project.php';
$project = new Project($path . 'project.json', __DIR__);

require_once $includes . $sep . 'Autoload' . $sep . 'Autoloader.php';
(new Autoload\Autoloader($project->getAutoloaderSources()))->register();

(new FileLoader(...$project->getFileSources()))->loadFiles();

$config = new TestsConfiguration($config_file, $tests_folder);
$config->buildConfig();

$app = Application::instance($config);

if (SourceChecker::isCli()) {
    print('Tests complete.' . PHP_EOL);
    Application::getTestResults()->printResults();
}
