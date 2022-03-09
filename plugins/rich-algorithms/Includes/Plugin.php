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
use RichWeb\Algorithms\Setup\Setup;
use RichWeb\Algorithms\Abstracts\AbstractSyntaxHighlighter;
use RichWeb\Algorithms\PrismSyntaxHighlighter;
use RichWeb\Algorithms\Admin\{
    AlgorithmPostType,
    MetaBoxes\MetaBoxes
};

final class Plugin extends AbstractSingletonPlugin
{
    /**
     * Plugin file.
     */
    private string $file = RICH_ALGO_FILE;

    private AlgorithmPackageManager $algorithm_package_manager;

    private AbstractSyntaxHighlighter $syntax;

    protected function __construct(Project $project)
    {
        $this->project        = $project;
        $this->name           = $project->getName();
        $this->version        = $project->getVersion();
        $this->requirements   = $project->getRequirements();
        $this->main_directory = $project->getMainDirectory();
        $this->text_domain    = RICH_ALGO_TEXT_DOMAIN;
    }

    protected function build(): void
    {
        $this->initHooks();
        $this->loadModules();
    }

    /**
     * Hook into actions and filters.
     */
    private function initHooks(): void
    {
        register_activation_hook($this->file, array($this, 'activated'));
        register_deactivation_hook($this->file, array($this, 'aeactivated'));

        add_action('plugins_loaded', [$this, 'pluginsLoadedSetup'], -1);
        add_action('init', [$this, 'initSetup'], 0);
    }

    public function activated(): void
    {
        \flush_rewrite_rules();
        do_action('rich_algo_activate');
    }

    public function deactivated(): void
    {
        do_action('rich_algo_deactivate');
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
        (new Setup($this->text_domain, RICH_ALGO_PLUGIN_PATH))->run();
    }

    /**
     * Called when the 'init' WP action is fired.
     * 
     * @return void
     */
    public function initSetup(): void
    {
        $this->syntax = new PrismSyntaxHighlighter();
        $this->algorithm_package_manager = new AlgorithmPackageManager($this->main_directory, $this->syntax);

        (new AlgorithmPostType())->run();
        (new MetaBoxes($this->main_directory, $this->algorithm_package_manager, $this->syntax))->run();
    }

    private function loadModules(): void
    {
        do_action('rich_algo_loaded_modules');
    }

    public function syntaxHighlighter(): AbstractSyntaxHighlighter
    {
        return $this->syntax;
    }

    public function packageManager(): AlgorithmPackageManager
    {
        return $this->algorithm_package_manager;
    }
}
