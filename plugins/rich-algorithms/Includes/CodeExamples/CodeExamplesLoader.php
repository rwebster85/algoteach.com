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

use RichWeb\Algorithms\CodeExamples\CodeExampleModel;
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
        private array $code_languages
    ) {}

    final public function subscribeToEvents(EventSubscriberInterface $subscriber): void
    {
        $subscriber->subscribe('template_redirect', [$this, 'canLoadCodeExamplesForPost']);
        $subscriber->subscribe('the_content', [$this, 'canAppendExamplesToContent']);
    }

    /**
     * Verifies the post is applicable for appending code examples to content.
     * 
     * Hooked from 'template_redirect' WP Action
     * 
     * @uses AlgorithmChecker::isSingleAlgorithm()
     * @uses CodeExamplesLoader::canLoadCodeExamplesForPost()
     * @uses \absint() WP Function
     * @uses \get_the_ID() WP Function
     * 
     * @see https://developer.wordpress.org/reference/hooks/template_redirect/ WP Action
     * 
     * @return void
     */
    final public function canLoadCodeExamplesForPost(): void
    {
        if ($this->isSingleAlgorithm()) {
            $post_id = absint(get_the_ID() ?? 0);
            if ($post_id > 0) {
                $this->loadCodeExamplesForPost($post_id);
            }
        }
    }

    /**
     * Obtains the code examples from the post meta and builds the class code examples. Called from canLoadCodeExamplesForPost()
     * 
     * @param $post_id The post Id to get the code examples for
     * 
     * @uses CodeExamplesLoader::buildCodeExamples()
     * @uses \get_post_meta() WP Function
     * 
     * @return void
     */
    final public function loadCodeExamplesForPost(int $post_id): void
    {
        $code_examples = (array) get_post_meta($post_id, 'richweb_algorithm_code_examples', true);
        if (!empty($code_examples)) {
            $this->buildCodeExamples($code_examples);
        }
    }

    final public function buildCodeExamples(array $code_examples): void
    {
        foreach ($code_examples as $example) {
            if (!is_array($example) || empty($example)) {
                continue;
            }
            $this->code_examples[] = new CodeExampleModel($example, $this->code_languages);
        }
    }

    final public function canAppendExamplesToContent(?string $content = ''): ?string
    {
        if (!$this->isSingleAlgorithm() || empty($this->code_examples)) {
            return $content;
        }

        return $this->appendExamplesToContent($content);
    }

    final public function appendExamplesToContent(?string $content = ''): string
    {
        $model = new CodeExamplesModel($this->getCodeExamples());
        return $content . $model->getContent();
    }

    final public function getCodeExamples(): array
    {
        return $this->code_examples;
    }
}
