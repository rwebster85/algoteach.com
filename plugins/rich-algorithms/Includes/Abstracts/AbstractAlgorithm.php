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

namespace RichWeb\Algorithms\Abstracts;

use RichWeb\Algorithms\AlgorithmPackage;
use RichWeb\Algorithms\CodeExample;
use RichWeb\Algorithms\Interfaces\AlgorithmInterface;
use RichWeb\Algorithms\Interfaces\SyntaxHighlighterInterface;

abstract class AbstractAlgorithm implements AlgorithmInterface
{
    private array $code_examples;

    final public function __construct(
        private AlgorithmPackage $package,
        private int $post_id,
        private SyntaxHighlighterInterface $syntax
    ) {
        $this->buildCodeExamples();
        $this->actions();
        $this->run();
    }

    public function actions(): void
    {
        add_filter('the_content', [$this, 'appendExamplesToContent']);
    }

    final public function appendExamplesToContent(string $content): string
    {
        if (empty($this->code_examples)) {
            return '';
        }

        ob_start();

        echo '<div class="rich-algo-frontend-examples-wrap">';

        /** @var CodeExample $example */
        foreach ($this->code_examples as $example) {
            echo $example;
        }

        echo '</div>';

        $after = ob_get_clean();
        return $content . $after;
    }

    private function buildCodeExamples(): void
    {
        $examples = get_post_meta($this->post_id, 'richweb_algorithm_code_examples', true);

        foreach ($examples as $example) {
            $this->code_examples[] = new CodeExample($example, $this->syntax);
        }
    }

    final public function getCodeExamples(): array
    {
        return $this->code_examples;
    }

    /**
     * Can bo be implemented in the concrete class for additional functionality. Always called during construction.
     * 
     * @return void
     */
    protected function run(): void {}
}
