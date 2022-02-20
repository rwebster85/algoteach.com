<?php
/**
 * This file sets up the class autoloader and runs the application.
 */

namespace RichPHPTests;

$sep = DIRECTORY_SEPARATOR;
$path = __DIR__ . $sep;
$includes = $path . 'Includes' . $sep;

require_once $includes . 'Project.php';
$project = new Project($path . 'project.json', __DIR__);

require_once $includes . 'Autoload' . $sep . 'Autoloader.php';
(new Autoload\Autoloader($project->getAutoloaderSources()))->register();

(new FileLoader(...$project->getFileSources()))->loadFiles();

$config = new TestsConfiguration($config_file, $tests_folder);

$app = Application::instance($config);

if (SourceChecker::isCli()) {
    print('Tests complete.' . PHP_EOL);
    Application::getTestResults()->printResults();
}
