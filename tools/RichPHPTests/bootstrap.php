<?php
/**
 * This file sets up the class autoloader and runs the application.
 */

namespace RichPHPTests;

$sep = DIRECTORY_SEPARATOR;

// Include the Autoloader file
require_once $path . 'Includes' . $sep . 'Autoload' . $sep. 'Autoloader.php';
(new Autoloader([
    'RichPHPTests' => $path . 'Includes',
]))->register();

$config = new TestsConfiguration($config_file, $tests_folder);
$config->buildConfig();

$app = Application::instance($config);

if (SourceChecker::isCli()) {
    print('Tests complete.' . PHP_EOL);
    Application::getTestResults()->printResults();
}
