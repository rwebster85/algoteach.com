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

defined('WPINC') || exit;

use RichWeb\Algorithms\{
    Plugin,
    Project,
    Loaders\Autoloader,
    Loaders\FileLoader
};

$sep = DIRECTORY_SEPARATOR;
$includes = 'Includes' . $sep;

require_once $includes . 'Project.php';
$project = new Project(__DIR__ . $sep . 'project.json', __DIR__);
$project->buildProject();

define('RICH_ALGO_VER', $project->getVersion());
define('RICH_ALGO_TEXT_DOMAIN', 'rich-algo');
define('RICH_ALGO_PLUGIN_NAME_FULL', $project->getName());
define('RICH_ALGO_PATH', plugin_dir_path(RICH_ALGO_FILE));
define('RICH_ALGO_PLUGIN_PATH', plugin_basename(dirname(RICH_ALGO_FILE)));
define('RICH_ALGO_PLUGIN_BASENAME', plugin_basename(RICH_ALGO_FILE));

require_once $includes . 'Interfaces' . $sep . 'AutoloaderInterface.php';
require_once $includes . 'Loaders' . $sep . 'Autoloader.php';
(new Autoloader($project->getAutoloaderSources()))->register();

(new FileLoader(...$project->getFileSources()))->loadFiles();

Plugin::instance($project);
