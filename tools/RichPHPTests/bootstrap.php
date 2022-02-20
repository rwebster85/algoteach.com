<?php
/**
 * This file sets up the class autoloader and runs the application.
 */

namespace RichPHPTests;

$sep = DIRECTORY_SEPARATOR;

require_once 'Includes' . $sep . 'Project.php';
$project = new Project(__DIR__ . $sep . 'project.json', __DIR__);
$project->buildProject();

require_once 'Includes' . $sep . 'Autoload' . $sep . 'Autoloader.php';
(new Autoload\Autoloader($project->getAutoloaderSources()))->register();

(new FileLoader(...$project->getFileSources()))->loadFiles();

$config = new TestsConfiguration($config_file, $tests_folder);
$config->buildConfig();

$app = Application::instance($config);

if (SourceChecker::isCli()) {
    print('Tests complete.' . PHP_EOL);
    Application::getTestResults()->printResults();
}
