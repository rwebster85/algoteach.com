<?php
/**
 * This file sets up the class autoloader and runs the application.
 */

namespace RichPHPTests;

// Include the Autoloader file
require_once $path . 'Includes' . DIRECTORY_SEPARATOR . 'Autoload' . DIRECTORY_SEPARATOR. 'Autoloader.php';
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
