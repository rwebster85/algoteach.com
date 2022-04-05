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

use RichWeb\Algorithms\CodeExamples\CodeExampleModel;
use RichWeb\Algorithms\ContentLoader;

/**
 * @var CodeExampleModel $content
 * @var ContentLoader $loader
 */

?>

<div class="rich-algo-frontend-code-example">
    <div class="rich-algo-frontend-code-example-info">
        <?php
            $formatted_language = $content->getLanguageFormatted();
            $pre_language       = $formatted_language;
            $example_title      = $formatted_language;
            $language_version   = ($content->getLanguageVersion() ?? '');
            if (!empty($language_version)) {
                $example_title .= ' ' . $language_version;
                $pre_language  .= ' ' . $language_version;
            }
            $example_title .= ' Implementation';
        ?>
        <h3><?php echo $loader->escHtml($example_title); ?></h3>
        <?php echo $loader->ksesPost($loader->autoP($content->getInfo())); ?>
    </div>
    <div class="rich-algo-frontend-code-wrap">
        <span class="rich-algo-frontend-code-language"><?php echo $loader->escHtml(strtoupper($pre_language)); ?></span>
        <pre class="line-numbers"><code class="language-<?php echo $loader->escAttr($content->getLanguage()); ?>"><?php echo $loader->escHtml($content->getCode()); ?></code></pre>
        <textarea class="rich-algo-frontend-code-example-textarea"><?php echo $loader->escTextarea($content->getCode()); ?></textarea>
        <p class="rich-algo-frontend-code-toolbar"><button class="button button-primary rich-algo-copy"><i class="fas"></i> Copy</button></p>
    </div>
</div>

<?php
