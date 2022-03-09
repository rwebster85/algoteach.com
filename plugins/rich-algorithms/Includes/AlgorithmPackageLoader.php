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

use RichWeb\Algorithms\AlgorithmPackage;
use RichWeb\Algorithms\Interfaces\AlgorithmPackageLoaderInterface;
use RichWeb\Algorithms\Interfaces\HasRunnerInterface;
use RichWeb\Algorithms\Interfaces\SyntaxHighlighterInterface;

final class AlgorithmPackageLoader implements AlgorithmPackageLoaderInterface, HasRunnerInterface
{
    /**
     * @var array<string, AlgorithmPackage>
     */
    public function __construct(
        private array $packages,
        private SyntaxHighlighterInterface $syntax
    ) {}

    public function run(): void
    {
        add_action('template_redirect', [$this, 'loadPackageForPost']);
    }

    /**
     * Loads the package for the current global post, hooked from 'template_redirect' WP Action
     * 
     * @see https://developer.wordpress.org/reference/hooks/template_redirect/ WP Action
     * 
     * @return void
     */
    public function loadPackageForPost(): void
    {
        if (is_singular('richweb_algorithm')) {
            $post_id = absint(get_the_ID() ?? 0);
            $package = $this->postHasPackage($post_id);
            if (!empty($package)) {
                $this->loadPackage($package, $post_id);
            }
        }
    }

    private function postHasPackage($post_id): bool|string
    {
        return get_post_meta($post_id, 'richweb_algorithm_package', true);
    }

    public function getPackages(): array
    {
        return $this->packages;
    }

    public function loadPackage(string $name, int $post_id): void
    {
        if (array_key_exists($name, $this->packages)) {
            /** @var AlgorithmPackage $package */
            $package = $this->packages[$name];
            $path = $package->getPath();
            if (file_exists($path)) {
                require_once $path;
                $class = $package->getQualifiedClassName();
                (new $class($package, $post_id, $this->syntax));
            }
        }
    }
}
