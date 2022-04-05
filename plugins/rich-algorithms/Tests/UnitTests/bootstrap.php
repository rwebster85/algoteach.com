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

namespace RichAlgoUnitTests;

use RichWeb\Algorithms\{
    Project,
    Loaders\Autoloader,
    Loaders\FileLoader
};

use const DIRECTORY_SEPARATOR as SEP;

$plugin_path      = dirname(dirname(dirname(__FILE__)));
$includes         = $plugin_path . SEP . 'Includes' . SEP;
$plugin_namespace = 'RichWeb\Algorithms';

require_once $includes . 'Interfaces' . SEP . 'ProjectInterface.php';
require_once $includes . 'Project.php';
$project = new Project($plugin_path . SEP . 'project.json', $plugin_path);
$project->buildProject();

require_once $includes . 'Interfaces' . SEP . 'AutoloaderInterface.php';
require_once $includes . 'Loaders' . SEP . 'Autoloader.php';
(new Autoloader($project->getAutoloaderSources()))->register();

(new FileLoader(...$project->getFileSources()))->loadFiles();

define($plugin_namespace . '\PLUGIN_FILE', $plugin_path . SEP . 'rich-algorithms.php');
define($plugin_namespace . '\VERSION', $project->getVersion());
define($plugin_namespace . '\PLUGIN_NAME_FULL', $project->getName());
define($plugin_namespace . '\TEXT_DOMAIN', 'rich-algo');
