<?php

declare(strict_types=1);

namespace RichPHPTests;

$min_php = '8.0.3';

$path = __DIR__ . DIRECTORY_SEPARATOR;

// Code adapted from Sebastian Bergmann, 2020
if (version_compare($min_php, PHP_VERSION, '>')) {
    fwrite(
        STDERR,
        sprintf(
            'This testing framework requires a minimum PHP version of %1s.' . PHP_EOL .
            'You are running version %2s (%3s).' . PHP_EOL,
            $min_php,
            PHP_VERSION,
            PHP_BINARY
        )
    );
    die(1);
}
//end of adapted code

$tests_folder = $path . 'Tests';//$argv[1] ?? null;

if (is_null($tests_folder)) {
    fwrite(
        STDERR,
        'Missing parameter for test folder.' . PHP_EOL
    );
    die(1);
}

if (!file_exists($tests_folder) && !is_dir($tests_folder) ) {
    fwrite(
        STDERR,
        sprintf(
            'The tests folder provided (%s) does not exist.' . PHP_EOL,
            strval($tests_folder),
        )
    );
    die(1);
}

$config_file = $tests_folder . DIRECTORY_SEPARATOR . 'config.json';
if (!file_exists($config_file) && !is_dir($config_file) ) {
    fwrite(
        STDERR,
        sprintf(
            'There is no config.json file present in folder (%s).' . PHP_EOL,
            strval($tests_folder),
        )
    );
    die(1);
}

require_once 'bootstrap.php';
