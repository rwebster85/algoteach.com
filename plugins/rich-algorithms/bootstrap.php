<?php

/*
 * This file is part of Rich Algorithms.
 *
 * Copyright (c) Richard Webster
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace RichWeb\Algorithms;

use const RichWeb\Algorithms\PLUGIN_FILE;
use const DIRECTORY_SEPARATOR as SEP;

use RichWeb\Algorithms\{
    Plugin,
    Project,
    Loaders\Autoloader,
    Loaders\FileLoader
};

defined('WPINC') || exit;

(function() {
    $includes = 'Includes' . SEP;

    require_once $includes . 'Interfaces' . SEP . 'ProjectInterface.php';
    require_once $includes . 'Project.php';
    require_once $includes . 'Interfaces' . SEP . 'AutoloaderInterface.php';
    require_once $includes . 'Loaders' . SEP . 'Autoloader.php';

    $project = new Project(__DIR__ . SEP . 'project.json', __DIR__);
    $project->buildProject();
    
    (new Autoloader($project->getAutoloaderSources()))->register();
    (new FileLoader(...$project->getFileSources()))->loadFiles();
    
    define(__NAMESPACE__ . '\VERSION', $project->getVersion());
    define(__NAMESPACE__ . '\PLUGIN_NAME_FULL', $project->getName());
    define(__NAMESPACE__ . '\TEXT_DOMAIN', 'rich-algo');
    
    // Resolves to: path\to\plugin\folder
    define(__NAMESPACE__ . '\PATH', plugin_dir_path(PLUGIN_FILE));
    
    // Resolves to: plugin_folder_name
    define(__NAMESPACE__ . '\PLUGIN_PATH', plugin_basename(dirname(PLUGIN_FILE)));
    
    Plugin::instance($project);
})();
