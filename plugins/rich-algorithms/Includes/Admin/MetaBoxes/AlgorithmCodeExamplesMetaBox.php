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

namespace RichWeb\Algorithms\Admin\MetaBoxes;

use RichWeb\Algorithms\Admin\Abstracts\AbstractMetaBox;
use RichWeb\Algorithms\Abstracts\AbstractSyntaxHighlighter;
use RichWeb\Algorithms\Traits\Formatting;

/**
 * This Meta Box outputs the algorithm package selection.
 */
final class AlgorithmCodeExamplesMetaBox extends AbstractMetaBox
{
    use Formatting\FilePaths;
    use Formatting\Strings;

    private int $post_id;

    public function __construct(
        private string $main_directory,
        private AbstractSyntaxHighlighter $syntax
    ) {
        add_action('wp_ajax_richweb_algorithm_code_example_add', [$this, 'ajaxAddNewCodeExample']);
    }

    public function add(): void
    {
        add_meta_box(
            'richweb_algorithm_code_examples',
            __('Code Examples', 'rich-algo'),
            [$this, 'html'],
            'richweb_algorithm',
            'normal',
            'core'
        );
    }

    public function html(\WP_Post $post): void
    {
        $this->post_id = $post->ID;

        wp_nonce_field('_richweb_algorithm_code_examples_nonce', 'richweb_algorithm_code_examples_nonce');

        include_once dirname(__FILE__) . '\..\Content\CodeExamplesMetaDetails.php';
    }

    /**
     * Returns a code example element for the metabox.
     * 
     * @param int $key
     * @param string $lang
     * @param string $code
     * 
     * @return string
     */
    private function getCodeExampleElement(int $key, string $lang = '', string $code = '', string $info = ''): string
    {
        ob_start();

        include dirname(__FILE__) . $this->formatSlashes('\..\Content\CodeExamplesMetaField.php');

        $content = ob_get_clean();

        return $content;
    }

    public function getCodeExampleInfoEditor($content, $key): string
    {
        ob_start();
        echo '<div class="rich-algo-meta-field-info-wrap">';
        $editor_id = 'richweb_algorithm_code_examples-'.$key.'';
        $editor_name = 'richweb_algorithm_code_examples['.$key.'][info]';
        $settings = array(
            'media_buttons' => false,
            'quicktags' => true,
            'teeny' => true,
            'editor_height' => 200,
            'textarea_name' => $editor_name
        );
    
        wp_editor($content, $editor_id, $settings);
    
        echo '</div>';
    
        $editor = ob_get_clean();
        
        return $editor;
    }

    public function getCodeExamples(): array
    {
        return (array) get_post_meta($this->getPostId(), 'richweb_algorithm_code_examples', true);
    }

    public function getPostId(): int
    {
        return $this->post_id;
    }

    /**
     * AJAX call when adding a new code example to the metabox.
     * 
     * @uses AlgorithmCodeExamplesMetaBox::getCodeExampleElement()
     * 
     * @return void
     */
    public function ajaxAddNewCodeExample(): void
    {
        check_ajax_referer('rich-algo-example-add-new', 'security');

        $result = '';

        $key = absint($this->sanitise($_REQUEST['key'] ?? ''));

        $result = $this->getCodeExampleElement($key);

        echo json_encode($result);
        wp_die();
    }

    public function save(int $post_id): void
    {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

        if (!isset($_POST['richweb_algorithm_code_examples_nonce']) || !wp_verify_nonce($_POST['richweb_algorithm_code_examples_nonce'], '_richweb_algorithm_code_examples_nonce')) return;

        if (!current_user_can('update_core', $post_id)) return;

        $code_examples = (array) ($_POST['richweb_algorithm_code_examples'] ?? []);

        foreach ($code_examples as $key => $example) {
            if (!array_filter($example)) {
                unset($code_examples[$key]);
            }
        }

        $code_examples = array_values($code_examples);

        if (!empty($code_examples)) {
            update_post_meta($post_id, 'richweb_algorithm_code_examples', $code_examples);
        } else {
            update_post_meta($post_id, 'richweb_algorithm_code_examples', null);
        }
    }

    /**
     * Returns a key/value array of supported code example languages. Key is the PrismJS name, value is the name formatted for display.
     * 
     * @return array<string, string>
     */
    public function supportedLanguages(): array
    {
        return $this->syntax->languages();
    }
}
