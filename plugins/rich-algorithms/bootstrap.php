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

defined('WPINC') || exit;

use RichWeb\Algorithms\{
    Plugin,
    Project,
    Loaders\Autoloader,
    Loaders\FileLoader
};

$sep = DIRECTORY_SEPARATOR;
$includes = 'Includes' . $sep;

require_once $includes . 'Interfaces' . $sep . 'ProjectInterface.php';
require_once $includes . 'Project.php';
$project = new Project(__DIR__ . $sep . 'project.json', __DIR__);
$project->buildProject();

define(__NAMESPACE__ . '\VERSION', $project->getVersion());
define(__NAMESPACE__ . '\PLUGIN_NAME_FULL', $project->getName());
define(__NAMESPACE__ . '\TEXT_DOMAIN', 'rich-algo');

// Resolves to: path\to\plugin\folder
define(__NAMESPACE__ . '\PATH', plugin_dir_path(PLUGIN_FILE));

// Resolves to: plugin_folder_name
define(__NAMESPACE__ . '\PLUGIN_PATH', plugin_basename(dirname(PLUGIN_FILE)));
 
/**
 * Resolves to: plugin_folder_name\plugin_filename.php
 * 
 * Can be used by plugins to detect if this plugin is active by using `is_plugin_active(RichWeb\Algorithms\PLUGIN_BASENAME)`
 */
define(__NAMESPACE__ . '\PLUGIN_BASENAME', plugin_basename(PLUGIN_FILE));

require_once $includes . 'Interfaces' . $sep . 'AutoloaderInterface.php';
require_once $includes . 'Loaders' . $sep . 'Autoloader.php';
(new Autoloader($project->getAutoloaderSources()))->register();

(new FileLoader(...$project->getFileSources()))->loadFiles();

Plugin::instance($project);
