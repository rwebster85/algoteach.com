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

namespace RichWeb\Algorithms\Setup;

use RichWeb\Algorithms\Interfaces\EventSubscriberInterface;
use RichWeb\Algorithms\Interfaces\HasRunnerInterface;

/**
 * Class responsible for running plugin set up such as loading scripts.
 */
class Setup implements HasRunnerInterface
{
    public function __construct(
        private string $text_domain,
        private string $plugin_path,
        private EventSubscriberInterface $subscriber
    ) {}

    /**
     * Runs the class init functions not handled during construction.
     * 
     * @uses Setup::textDomainLoader()
     * @uses Setup::scriptLoader()
     * 
     * @return void
     */
    public function run(): void
    {
        $this->textDomainLoader();
        $this->scriptLoader();
    }

    /**
     * Creates a new instance of Languages to load the text domain.
     * 
     * @uses RichWeb\Algorithms\Setup\Languages
     * 
     * @return void
     */
    private function textDomainLoader(): void
    {
        (new Languages($this->text_domain, $this->plugin_path, $this->subscriber))->run();
    }

    /**
     * Creates a new instance of Scripts to load the JS and CSS files.
     * 
     * @uses RichWeb\Algorithms\Setup\Scripts
     * 
     * @return void
     */
    private function scriptLoader(): void
    {
        (new Scripts())->run();
    }
}
