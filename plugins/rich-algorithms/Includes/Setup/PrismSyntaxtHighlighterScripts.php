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

use RichWeb\Algorithms\Abstracts\AbstractScripts;

class PrismSyntaxtHighlighterScripts extends AbstractScripts
{
    public function __construct() {}

    public function registerAdminScripts(): void {}

    public function registerFrontendScripts(): void {}

    public function enqueueAdminScripts(string $hook): void {}

    public function enqueueFrontendScripts(): void
    {
        $js_cdn = 'https://cdnjs.cloudflare.com/ajax/libs/prism/1.27.0/prism.min.js';
        
        $css_cdn = 'https://cdnjs.cloudflare.com/ajax/libs/prism/1.27.0/themes/prism-okaidia.min.css';


        $js_autoload = 'https://cdnjs.cloudflare.com/ajax/libs/prism/1.27.0/plugins/autoloader/prism-autoloader.min.js';

        $line_numbers_css_cdn = 'https://cdnjs.cloudflare.com/ajax/libs/prism/1.27.0/plugins/line-numbers/prism-line-numbers.min.css';
        $line_numbers_js_cdn = 'https://cdnjs.cloudflare.com/ajax/libs/prism/1.27.0/plugins/line-numbers/prism-line-numbers.min.js';

        wp_enqueue_script('rich-algo-prism-script', $js_cdn, [], '1.27.0', true);
        wp_enqueue_script('rich-algo-prism-linenumbers-script', $line_numbers_js_cdn, [], '1.27.0', true);
        wp_enqueue_script('rich-algo-prism-auto-script', $js_autoload, [], '1.27.0', true);
        
        wp_enqueue_style('rich-algo-prism-style', $css_cdn, [], '1.27.0');
        wp_enqueue_style('rich-algo-prism-linenumbers-style', $line_numbers_css_cdn, [], '1.27.0');
    }
}
