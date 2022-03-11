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

namespace RichWeb\Algorithms\CodeExamples;

use RichWeb\Algorithms\CodeExamples\CodeExample;
use RichWeb\Algorithms\Interfaces\CodeExamplesLoaderInterface;
use RichWeb\Algorithms\Interfaces\HasRunnerInterface;
use RichWeb\Algorithms\Interfaces\SyntaxHighlighterInterface;
use RichWeb\Algorithms\Traits\Posts\AlgorithmChecker;

/**
 * Responsbile for loading code examples on the frontend if the post has any.
 */
final class CodeExamplesLoader implements CodeExamplesLoaderInterface, HasRunnerInterface
{
    use AlgorithmChecker;
    
    private array $code_examples = [];

    public function __construct(
        private array $code_languages
    ) {}

    public function run(): void
    {
        $this->actions();
    }

    /**
     * The action hooks to set up on initialisation.
     * 
     * @uses \add_action() WP Function
     * @see https://developer.wordpress.org/reference/hooks/init/ WP action
     * 
     * @return void
     */
    private function actions(): void
    {
        add_action('template_redirect', [$this, 'loadCodeExamplesForPost']);
        add_filter('the_content', [$this, 'appendExamplesToContent']);
    }

    /**
     * Loads the package for the current global post, hooked from 'template_redirect' WP Action
     * 
     * @see https://developer.wordpress.org/reference/hooks/template_redirect/ WP Action
     * 
     * @return void
     */
    public function loadCodeExamplesForPost(): void
    {
        if ($this->isSingleAlgorithm()) {

            $post_id = absint(get_the_ID() ?? 0);

            $code_examples = (array) get_post_meta($post_id, 'richweb_algorithm_code_examples', true);
            if (!empty($code_examples)) {
                $this->buildCodeExamples($code_examples);
            }
        }
    }

    private function buildCodeExamples(array $code_examples): void
    {
        foreach ($code_examples as $example) {
            if (!is_array($example) || empty($example)) {
                continue;
            }
            $this->code_examples[] = new CodeExample($example, $this->code_languages);
        }
    }

    final public function appendExamplesToContent(string $content): string
    {
        if (empty($this->code_examples)) {
            return $content;
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

    final public function getCodeExamples(): array
    {
        return $this->code_examples;
    }
}
