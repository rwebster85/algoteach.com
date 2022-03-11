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

use RichWeb\Algorithms\CodeExamples\CodeExample;

/** @var CodeExample $this **/ ?>

<div class="rich-algo-frontend-code-example">
    <div class="rich-algo-frontend-code-example-info">
        <?php
            $formatted_language = $this->getLanguageFormatted();
            $pre_language       = $formatted_language;
            $example_title      = $formatted_language;
            $language_version   = ($this->getLanguageVersion() ?? '');
            if (!empty($language_version)) {
                $example_title .= ' ' . $language_version;
                $pre_language  .= ' ' . $language_version;
            }
            $example_title .= ' Implementation';
        ?>
        <h3><?php echo $this->escHtml($example_title); ?></h3>
        <?php echo $this->ksesPost($this->getInfoAutoP()); ?>
    </div>
    <div class="rich-algo-frontend-code-wrap">
        <span class="rich-algo-frontend-code-language"><?php echo $this->escHtml(strtoupper($pre_language)); ?></span>
        <pre class="line-numbers"><code class="language-<?php echo $this->escAttr($this->getLanguage()); ?>"><?php echo $this->escHtml($this->getCode()); ?></code></pre>
        <textarea class="rich-algo-frontend-code-example-textarea"><?php echo $this->escTextarea($this->getCode()); ?></textarea>
        <p class="rich-algo-frontend-code-toolbar"><button class="button button-primary rich-algo-copy"><i class="fas"></i> Copy</button></p>
    </div>
</div>

<?php
