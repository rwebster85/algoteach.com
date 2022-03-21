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

use RichWeb\Algorithms\Abstracts\AbstractSingletonPlugin;
use RichWeb\Algorithms\Admin\AlgorithmPostType;
use RichWeb\Algorithms\Admin\MetaBoxes\MetaBoxes;
use RichWeb\Algorithms\CodeExamples\CodeExamplesLoader;
use RichWeb\Algorithms\Events\WPEventCreator;
use RichWeb\Algorithms\Events\WPEventSubscriber;
use RichWeb\Algorithms\Interfaces\AlgorithmPackageManagerInterface;
use RichWeb\Algorithms\Interfaces\EventSubscriberInterface;
use RichWeb\Algorithms\Interfaces\ProjectInterface;
use RichWeb\Algorithms\Interfaces\SyntaxHighlighterInterface;
use RichWeb\Algorithms\Packages\AlgorithmPackageLoader;
use RichWeb\Algorithms\Packages\AlgorithmPackageManager;
use RichWeb\Algorithms\PrismSyntaxHighlighter;
use RichWeb\Algorithms\Setup\Setup;
use RichWeb\Algorithms\Traits\Formatting\FilePathsTrait;

use const RichWeb\Algorithms\{
    PLUGIN_FILE,
    PLUGIN_PATH,
    TEXT_DOMAIN
};

final class Plugin extends AbstractSingletonPlugin
{
    use FilePathsTrait;

    private AlgorithmPackageManagerInterface $algorithm_package_manager;

    private SyntaxHighlighterInterface $syntax;

    protected function __construct(ProjectInterface $project)
    {
        $this->project          = $project;
        $this->name             = $project->getName();
        $this->version          = $project->getVersion();
        $this->requirements     = $project->getRequirements();
        $this->main_directory   = $project->getMainDirectory();
        $this->text_domain      = TEXT_DOMAIN;
        $this->event_creator    = new WPEventCreator();
        $this->event_subscriber = new WPEventSubscriber();
    }

    protected function build(): void
    {
        $this->initHooks();
        $this->loadModules();

        $this->event_creator->create(__CLASS__ . '\BuildComplete', $this);
    }

    /**
     * Hook into actions and filters.
     */
    private function initHooks(): void
    {
        $this->subscribeToEvents($this->event_subscriber);
        $this->event_creator->create(__CLASS__ . '\InitHooksComplete');
    }

    final public function subscribeToEvents(EventSubscriberInterface $subscriber): void
    {
        $subscriber->subscribe('plugins_loaded', [$this, 'pluginsLoadedSetup'], -1);
        $subscriber->subscribe('init', [$this, 'initSetup'], 0);

        $subscriber->subscribe('activate_' . PLUGIN_FILE, [$this, 'activated']);
        $subscriber->subscribe('deactivate_' . PLUGIN_FILE, [$this, 'deactivated']);
    }

    public function activated(): void
    {
        $this->event_creator->create(__CLASS__ . '\Activated');
    }

    public function deactivated(): void
    {
        $this->event_creator->create(__CLASS__ . '\Deactivated');
    }

    /**
     * Called when the 'plugins_loaded' WP action is fired.
     * 
     * @uses RichWeb\Algorithms\Setup\Setup
     * 
     * @return void
     */
    public function pluginsLoadedSetup(): void
    {
        (new Setup($this->text_domain, PLUGIN_PATH, new WPEventSubscriber()))->run();

        $this->event_creator->create(__CLASS__ . '\PluginsLoadedSetupComplete');
    }

    /**
     * Called when the 'init' WP action is fired.
     * 
     * @return void
     */
    public function initSetup(): void
    {
        $this->syntax = new PrismSyntaxHighlighter();

        $package_folder = $this->formatSlashes(PATH . '/Algorithms/');
        $this->algorithm_package_manager = new AlgorithmPackageManager($package_folder);

        $packages = $this->algorithm_package_manager->getPackages();

        $package_loader = new AlgorithmPackageLoader($packages);
        $package_loader->run();

        (new AlgorithmPostType())->run();

        $coding_languages = $this->syntax->languages();
        
        (new CodeExamplesLoader($coding_languages))->subscribeToEvents(new WPEventSubscriber());
        (new MetaBoxes($packages, $coding_languages))->run();

        $this->event_creator->create(__CLASS__ . '\InitSetupComplete');
    }

    private function loadModules(): void
    {
        $this->event_creator->create(__CLASS__ . '\ModulesLoaded');
    }
}
