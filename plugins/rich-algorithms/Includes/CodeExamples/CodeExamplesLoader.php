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
use RichWeb\Algorithms\Interfaces\SubscribesToEventsInterface;
use RichWeb\Algorithms\Interfaces\EventSubscriberInterface;
use RichWeb\Algorithms\Traits\Posts\AlgorithmChecker;

/**
 * Responsbile for loading code examples on the frontend if the post has any.
 */
final class CodeExamplesLoader implements CodeExamplesLoaderInterface, SubscribesToEventsInterface
{
    use AlgorithmChecker;
    
    private array $code_examples = [];

    public function __construct(
        private array $code_languages,
        private EventSubscriberInterface $subscriber
    ) {}

    public function subscribeToEvents(): void
    {
        $this->subscriber->subscribe('template_redirect', $this, 'loadCodeExamplesForPost');
        $this->subscriber->subscribe('the_content', $this, 'appendExamplesToContent');
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

    final public function appendExamplesToContent(?string $content = ''): ?string
    {
        if (empty($this->code_examples)) {
            return $content;
        }

        ob_start();

        echo '<div class="rich-algo-frontend-examples-wrap">';

        echo '<h2><i class="fas fa-code"></i> Code Examples</h2>';

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
